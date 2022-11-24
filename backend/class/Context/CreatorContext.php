<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Context;

use noxkiwi\cookbook\Model\IngredientModel;
use noxkiwi\cookbook\Model\RecipeIngredientModel;
use noxkiwi\core\Constants\Mvc;
use noxkiwi\core\Context;
use noxkiwi\cookbook\Model\RecipeModel;
use noxkiwi\core\Helper\JsonHelper;
use noxkiwi\core\Helper\LinkHelper;
use noxkiwi\database\Database;
use noxkiwi\database\Query;
use noxkiwi\mailer\Mailer;
use noxkiwi\translator\Translator;

/**
 * I am the Context that creates a new Recipe on the ORM.
 *
 * @package      noxkiwi\cookbook\Context
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class CreatorContext extends Context
{
    private RecipeModel           $recipeModel;
    private IngredientModel       $ingredientModel;
    private RecipeIngredientModel $recipeIngredientModel;

    /**
     * @inheritDoc
     */
    protected function __construct()
    {
        parent::__construct();
        $this->recipeModel           = RecipeModel::getInstance();
        $this->ingredientModel       = IngredientModel::getInstance();
        $this->recipeIngredientModel = RecipeIngredientModel::getInstance();
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(): bool
    {
        parent::isAllowed();

        return true;
    }

    /**
     * I will show a simple front-end to create a new recipe.
     */
    protected function viewCreate(): void
    {
        if ($this->request->get('F00') !== 'baz') {
            return;
        }
        // Import from POST
        $name = $this->request->get('name');
        // BUILD RECIPE
        $recipe                  = $this->recipeModel->getEntry([]);
        $recipe->recipe_time     = $this->request->get('time');
        $recipe->recipe_skill    = $this->request->get('skill');
        $recipe->translation_key = Translator::normalizeKey("RECIPE_TITLE_$name");
        $recipe->description_key = Translator::normalizeKey("RECIPE_DESCRIPTION_$name");
        $recipe->save();
        /*
        // BUILD TITLE TRANSLATION

        // Since the translation_name is the primary key, the data-abstraction layer refuses to INSERT. It will formulate an UPDATE query which has no effect at all then.

        $titleTranslation                      = $this->translationModel->getEntry([]);
        $titleTranslation->translation_name    = $recipe->translation_key;
        $titleTranslation->translation_english = $this->request->get('title');
        $titleTranslation->translation_german  = $this->request->get('title');
        $titleTranslation->save();



        // BUILD DESCRIPTION TRANSLATION

        // Since the translation_name is the primary key, the data-abstraction layer refuses to INSERT. It will formulate an UPDATE query which has no effect at all then.

        $descriptionTranslation                      = $this->translationModel->getEntry([]);
        $descriptionTranslation->translation_name    = $recipe->description_key;
        $descriptionTranslation->translation_english = $this->request->get('description');
        $descriptionTranslation->translation_german  = $this->request->get('description');
        $descriptionTranslation->save();
        */

        // I know this is all absolute and utter BS but instead of fixing the abstraction layer to work as intended, this needs to be enough for now.
        $database                       = Database::getInstance();
        $title                          = $database->escape((string)$this->request->get('name'));
        $titleTranslation               = new Query();
        $titleTranslation->string       = <<<MYSQL
REPLACE INTO translation (`translation_name`, `translation_german`, `translation_english`) VALUES ('$recipe->translation_key', $title, $title);
MYSQL;
        $description                    = $database->escape((string)$this->request->get('description'));
        $descriptionTranslation         = new Query();
        $descriptionTranslation->string = <<<MYSQL
REPLACE INTO translation (`translation_name`, `translation_german`, `translation_english`) VALUES ('$recipe->description_key', $description, $description);
MYSQL;

        // Just to clarify that again, I'd really prefer to NEVER use direct access on the ORM but...
        $database->write($titleTranslation);
        $database->write($descriptionTranslation);
        // BUILD RECIPE<->INGREDIENTS
        foreach ((array)$this->request->get('ingredients', []) as $ingredient) {
            $ingredientEntry                            = $this->ingredientModel->loadEntry($ingredient['ingredient_id']);
            $recipeIngredient                           = $this->recipeIngredientModel->getEntry([]);
            $recipeIngredient->ingredient_id            = $ingredientEntry->ingredient_id;
            $recipeIngredient->recipe_id                = $recipe->recipe_id;
            $recipeIngredient->recipe_ingredient_amount = $ingredient['amount'];
            $recipeIngredient->save();
        }
        $this->response->set('recipe_url', LinkHelper::makeUrl([Mvc::CONTEXT => 'recipe', Mvc::VIEW => 'recipe', 'recipe_id' => $recipe->recipe_id]));

        // send mail to the head chef of hell's kitchen 🍽️
        $mailer = Mailer::getInstance();
        $mailer->setSubject("New recipe $title created");
        $mailer->setFrom('Nox Cookbook');
        $mailer->addTo('jan.nox@pm.me', 'Jan Nox');
        $mailer->setBody(<<<HTML
Some1 added a new recipe.
<br />
<p>
    $description
</p>
<p>
    Here's some arbitrary content for this recipe, since there's no real requirement WHAT this email must contain.
    <br />A software tester walks into a bar.
    <br />Walks into a bar
    <br />Runs into a bar.
    <br />Crawls into a bar.
    <br />Dances into a bar.
    <br />Flies into a bar.
    <br />Jumps into a bar.
    <br />And orders:
    <br />a beer.
    <br />2 beers.
    <br />0 beers.
    <br />99999999 beers.
    <br />a lizard in a beer glass.
    <br />-1 beer.
    <br />"qwertyuiop" beers.
    <br />Testing complete.
    <br />A real customer walks into the bar and asks where the bathroom is.
    <br />The bar goes up in flames.
</p>

HTML);
        $mailer->send();
        echo JsonHelper::encode($this->response->get());
        die();
    }
}
