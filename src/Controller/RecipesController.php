<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Recipes Controller
 *
 * @property \App\Model\Table\RecipesTable $Recipes
 */
class RecipesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $sortOptions = [
            "titleAsc" => "Title Ascending",
            "titleDesc" => "Title Descending",
            "dateAsc" => "Date Ascending",
            "dateDesc" => "Date Descending",
        ];

        $sorting = $this->request->getQuery('sort');
        $recipesQuery = $this->Recipes->find();
        $selectedSortOption = array_keys($sortOptions)[0];

        if ($sorting != null && in_array($sorting,array_keys($sortOptions))) {
            $values = array_keys($sortOptions);
            $selectedSortOption = $sorting;
            switch($sorting) {
                case $values[1]:
                    $recipes = $recipesQuery->order(['title' => 'DESC'])->all();
                    break;
                case $values[2]:
                    $recipes = $recipesQuery->order(['created' => 'ASC'])->all();
                    break;
                case $values[3]:
                    $recipes = $recipesQuery->order(['created' => 'DESC'])->all();
                    break;
                default:
                    $recipes = $recipesQuery->order(['title' => 'ASC'])->all();    
            }
        } else {
            $recipes = $recipesQuery->order(['title' => 'ASC'])->all();
        };

        $this->set(compact('selectedSortOption'));
        $this->set(compact('sortOptions'));
        $this->set(compact('recipes'));
    }

    /**
     * View method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recipe = $this->Recipes->get($id, contain: ['Ingredients']);
        $this->set(compact('recipe'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recipe = $this->Recipes->newEmptyEntity();
        if ($this->request->is('post')) {

            $failed = true;
            $recipe = $this->Recipes->patchEntity($recipe, $this->request->getData());
            if ($this->Recipes->save($recipe)) {
                $failed = false;
            }

            if (!$failed) {
                $ingredients = $this->request->getData('ingredients');
                foreach($ingredients as $ingredientsString) {
                    $ingredientsTable = $this->getTableLocator()->get('Ingredients');
                    $newIngredient = $ingredientsTable->newEmptyEntity();
                    $ingredientsArr = explode(";", $ingredientsString);
                    $newIngredient->description = $ingredientsArr[0];
                    $newIngredient->amount = (int)$ingredientsArr[1];
                    $newIngredient->unit = $ingredientsArr[2];
                    $newIngredient->recipe_id = $recipe->id;
                    
                    if ($ingredientsTable->save($newIngredient)) {
                        $failed = false;
                    } else {
                        $failed = true;
                    }
                }
            }

            if (!$failed) {
                $this->Flash->success(__('The recipe has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }

        $units = $this->fetchTable('Units')->find()->all();

        $this->set(compact('units'));
        $this->set(compact('recipe'));
    }

    /**
     * 
     * get description of a recipe for preview
     * 
     */
    public function getDescription() {

        $id = $this->request->getQuery('id');
        $recipe = $this->Recipes->find()->where(['id' => $id])->first();

        return $this->response->withType('application/json')
        ->withStringBody(json_encode(['description' => $recipe->description]));

    }

    /**
     * Edit method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $recipe = $this->Recipes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recipe = $this->Recipes->patchEntity($recipe, $this->request->getData());
            if ($this->Recipes->save($recipe)) {
                $this->Flash->success(__('The recipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }
        $this->set(compact('recipe'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recipe = $this->Recipes->get($id);
        if ($this->Recipes->delete($recipe)) {
            $this->Flash->success(__('The recipe has been deleted.'));
        } else {
            $this->Flash->error(__('The recipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
