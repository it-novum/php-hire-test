<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\View;
use App\Controller\ControllerTraits\RecipeIngredientsTrait;
use Cake\Mailer\Mailer;
use http\Client\Request;

/**
 * Recipes Controller
 *
 * @property \App\Model\Table\RecipesTable $Recipes
 * @method \App\Model\Entity\Recipe[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RecipesController extends AppController
{
    use RecipeIngredientsTrait;

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Recipes.id' => 'desc'
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $search = $this->request->getQuery('search');
        if (!empty($search)) {
            $recipes = $this->paginate($this->Recipes->find('all')->where(['name LIKE' => "%$search%"]), $this->paginate);
        } else {
            $recipes = $this->paginate($this->Recipes, $this->paginate);
        }
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
        $recipe = $this->Recipes->get($id, [
            'contain' => ['Ingredients'],
        ]);

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
            $requestData = $this->request->getData();
            $recipe = $this->Recipes->patchEntity($recipe, $requestData);
            if ($this->Recipes->save($recipe)) {
                try {
                    $this->ingredientsSave($recipe, $requestData, 'add');
                } catch (\Exception $e) {
                    $this->Flash->error(__('Rezept gespeichert, aber Zutaten konnten nicht vollständig hinzugefügt werden, bitte prüfen!'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->success(__('The recipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }
        $this->set(compact('recipe'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recipe = $this->Recipes->get($id, [
            'contain' => ['Ingredients'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $recipe = $this->Recipes->patchEntity($recipe, $requestData);

            if ($this->Recipes->save($recipe)) {
                try {
                    $this->ingredientsSave($recipe, $requestData, 'update');
                } catch (\Exception $e) {
                    $this->Flash->error(__('Rezept gespeichert, aber Zutaten konnten nicht vollständig upgedated werden, bitte prüfen!'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->success(__('The recipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }
        $this->set(compact('recipe'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recipe = $this->Recipes->get($id);
        if ($this->Recipes->delete($recipe)) {
            $this->Flash->success(__('The recipe has been deleted.'));
        } else {
            $this->Flash->error(__('The recipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param int $id
     * @return \Cake\Http\Response
     */
    public function ajax(int $id)
    {
        $recipe = $this->Recipes->get($id, [
            'contain' => ['Ingredients'],
        ]);
        $view = new View();
        $view->set(compact('recipe'));
        $html = $view->render('Recipes/ajax', false);
        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['html' => $html]));
    }

    public function email()
    {
        $requestData = $this->request->getData();
        $mailAdress = $requestData['inputEmail'];
        $recipe = $this->Recipes->get($requestData['recipeId'], [
            'contain' => ['Ingredients'],
        ]);

        $mailer = new Mailer('default');
        $mailer->setTransport('mailtrap');
        $mailer->setViewVars(['recipe' => $recipe])
            ->setEmailFormat('html');
        $mailer->setFrom(['Gourmet@example.com' => 'Meine süsse Seite'])
            ->setTo($mailAdress)
            ->setSubject('Koch mal wieder')
            ->viewBuilder()
            ->setTemplate('custom');
        $mailer->deliver();
        $this->Flash->success(__('Email erfolgreich versendet!'));
        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['status' => 'success']));
    }
}
