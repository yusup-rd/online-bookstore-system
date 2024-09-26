<?php
namespace App\Controller;

use App\Model\Entity\Category;
use App\Model\Entity\User;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    /**
     * IsAuthorized method.
     *
     * @param array|null $user The user data
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Allow all actions for admin or assistant
        return (User::isAdmin($user['role']) || User::isAssistant($user['role']));
    }

    /**
     * Index method.
     *
     * @return void
     */
    public function index()
    {
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /**
     * View method.
     *
     * @param string|null $id Category id
     * @return void
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Books.Users'],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method.
     *
     * @return \Cake\Http\Response|void|null
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method.
     *
     * @param string|null $id Category id
     * @return \Cake\Http\Response|void|null
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Books'],
        ]);
        $isDisableAllowed = count($category->books) === 0;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Check if the status change is to disabled and if not allowed
            if ($data['status'] === Category::STATUS_DISABLED && !$isDisableAllowed) {
                $this->Flash->error(__('The category cannot be disabled because it has related books.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method.
     *
     * @param string|null $id Category id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
