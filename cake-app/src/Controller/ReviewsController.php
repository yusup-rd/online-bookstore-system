<?php
namespace App\Controller;

use App\Model\Entity\User;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    /**
     * isAuthorized method
     *
     * @param array $user User
     * @return bool
     */
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $reviewId = $this->request->getParam('pass.0');

        if (in_array($action, ['index', 'view'])) {
            return true;
        }

        if ($action === 'add' && User::isMember($user['role'])) {
            return true;
        }

        if ($action === 'edit' && User::isMember($user['role'])) {
            $review = $this->Reviews->get($reviewId);

            return $review->user_id === $user['id'];
        }

        if ($action === 'delete') {
            if (User::isMember($user['role'])) {
                $review = $this->Reviews->get($reviewId);

                return $review->user_id === $user['id'];
            }

            return in_array($user['role'], ['assistant', 'admin']);
        }

        return false;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $this->paginate = [
            'finder' => [
                'byRole' => ['user' => $user],
            ],
            'contain' => ['Users', 'Books'],
        ];
        $reviews = $this->paginate($this->Reviews);
        $this->set(compact('reviews', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Review id
     * @return void
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => ['Users', 'Books'],
        ]);

        $this->set(compact('review'));
    }

    /**
     * Add method
     *
     * @param string|null $bookId Book id
     * @return \Cake\Http\Response|void|null
     */
    public function add($bookId = null)
    {
        $sessionUser = $this->Auth->user();
        $review = $this->Reviews->newEntity();
        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $book = $this->Reviews->Books->get($bookId);
        $users = $this->Reviews->Users->find();
        $this->set(compact('sessionUser', 'review', 'users', 'book'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|void|null
     */
    public function edit($id = null)
    {
        $sessionUser = $this->Auth->user();
        $review = $this->Reviews->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $book = $this->Reviews->Books->get($review->book_id);
        $users = $this->Reviews->Users->find();
        $this->set(compact('sessionUser', 'review', 'users', 'book'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
