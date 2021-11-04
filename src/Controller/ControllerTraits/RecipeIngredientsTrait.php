<?php

namespace App\Controller\ControllerTraits;

use App\Model\Entity\Recipe;

trait RecipeIngredientsTrait
{

    /**
     * @param Recipe $recipe
     * @param array $requestData
     * @param string $tag
     */
    protected function ingredientsSave (Recipe $recipe, array $requestData, string $tag = 'add'): void
        {
            $ingredientsTable = $this->getTableLocator()->get('Ingredients');
            if($tag == 'update') {
                $hayStack = $ingredientsTable->find('all')->where(['recipe_id' => $recipe->id]);
                $ingredientsTable->deleteMany($hayStack);
            }
            if(!empty($requestData['Ingredients']) && count($requestData['Ingredients']) > 0) {
                $associations = $requestData['Ingredients'];
                foreach ($associations as $association) {
                    if(!empty($association)) {
                        $data = ['recipe_id' => $recipe->id, 'ingredient' => $association];
                        $ingredient = $ingredientsTable->newEmptyEntity();
                        $ingredientsTable->patchEntity($ingredient, $data);
                        $ingredientsTable->save($ingredient);
                    }
                }
            }
        }
}
