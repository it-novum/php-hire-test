<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Model;

use noxkiwi\cache\Cache;
use noxkiwi\cookbook\Ingredient;
use noxkiwi\cookbook\Rating;
use noxkiwi\cookbook\Recipe;
use noxkiwi\dataabstraction\Entry;
use noxkiwi\dataabstraction\Model;
use DateTime;

/**
 * I am the storage for Recipes.
 *
 * @package      noxkiwi\cookbook\Model
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class RecipeModel extends Model
{
    public const TABLE = 'recipe';

    /**
     * I will solely create the Recipe object based on the given $recipeId.
     * After creation, I will utilize the calculate method to bring in the $multiplier.
     *
     * @see \noxkiwi\cookbook\Model\RecipeModel::calculateRecipe();
     *
     * @param int   $recipeId   I am the ID of the recipe that is being asked for.
     * @param float $multiplier I am the mutliplier for the recipe size to ease up calculation.
     *
     * @throws \noxkiwi\dataabstraction\Exception\EntryMissingException In case the given $recipeId does not exist.
     * @throws \noxkiwi\singleton\Exception\SingletonException          In case something wierd happens.
     *
     * @return \noxkiwi\cookbook\Recipe
     */
    public function createRecipe(int $recipeId, float $multiplier): Recipe
    {
        $cache         = Cache::getInstance();
        $cacheResponse = $cache->get('RECIPES', (string)$recipeId);
        if ($cacheResponse instanceof Recipe) {
            return $this->calculateRecipe($cacheResponse, $multiplier);
        }
        $recipeEntry               = self::expect($recipeId);
        $recipeObject              = new Recipe();
        $recipeObject->recipeId    = $recipeId;
        $recipeObject->name        = $recipeEntry->translation_key;
        $recipeObject->description = $recipeEntry->description_key;
        $recipeObject->multiplier  = $multiplier;
        $recipeObject->skill       = $recipeEntry->recipe_skill;
        $recipeObject->duration    = $recipeEntry->recipe_time;
        $recipeObject->ingredients = $this->getIngredients($recipeEntry);
        $recipeObject->views       = 422;
        $recipeObject->ratings     = [];
        $recipeObject->rating      = 0;
        // Fetch Ratings!
        $ratings = $this->getRatings($recipeEntry);
        if (! empty($ratings)) {
            $ratingCount = count($ratings);
            $sum         = 0;
            foreach ($ratings as $rating) {
                $ratingObject            = new Rating();
                $ratingObject->comment   = $rating['recipe_rating_comment'];
                $ratingObject->created   = new DateTime($rating['recipe_rating_created']);
                $ratingObject->stars     = $rating['recipe_rating_rating'];
                $recipeObject->ratings[] = $ratingObject;
                $sum                     += $rating['recipe_rating_rating'];
            }
            $recipeObject->rating = $sum / $ratingCount;
        }
        // Put to cache!
        $cache->set('RECIPES', (string)$recipeId, $recipeObject);

        return $this->calculateRecipe($recipeObject, $multiplier);
    }

    /**
     * I will solely recalculate the amount of every ingredient in the given $recipe on the given $multiplier.
     *
     * @param \noxkiwi\cookbook\Recipe $recipe
     * @param float                    $multiplier
     *
     * @return \noxkiwi\cookbook\Recipe
     */
    public function calculateRecipe(Recipe $recipe, float $multiplier): Recipe
    {
        foreach ($recipe->ingredients as $key => $ingredient) {
            $recipe->ingredients[$key]->amount = $ingredient->amount * $multiplier;
        }

        return $recipe;
    }

    /**
     * @param \noxkiwi\dataabstraction\Entry $recipe
     *
     * @throws \noxkiwi\dataabstraction\Exception\EntryMissingException
     * @throws \noxkiwi\singleton\Exception\SingletonException
     * @return \noxkiwi\dataabstraction\Entry[]
     */
    public function getIngredients(Entry $recipe): array
    {
        $return                = [];
        $recipeIngredientModel = RecipeIngredientModel::getInstance();
        $recipeIngredientModel->addFilter('recipe_id', $recipe->recipe_id);
        $recipeIngredients = $recipeIngredientModel->search();
        foreach ($recipeIngredients as $recipeIngredient) {
            $ingredient               = IngredientModel::expect($recipeIngredient['ingredient_id']);
            $ingredientObject         = new Ingredient();
            $ingredientObject->name   = $ingredient->translation_name;
            $ingredientObject->amount = $recipeIngredient['recipe_ingredient_amount'];
            $ingredientObject->unit   = $ingredient->ingredient_unit;
            $return[]                 = $ingredientObject;
        }

        return $return;
    }

    /**
     * @param \noxkiwi\dataabstraction\Entry $recipe
     *
     * @throws \noxkiwi\singleton\Exception\SingletonException
     * @return \noxkiwi\dataabstraction\Entry[]
     */
    public function getRatings(Entry $recipe): array
    {
        $ratingsModel = RatingModel::getInstance();
        $ratingsModel->addFilter('recipe_id', $recipe->recipe_id);

        return $ratingsModel->search();
    }
}
