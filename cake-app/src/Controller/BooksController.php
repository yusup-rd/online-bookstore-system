<?php
namespace App\Controller;

use App\Model\Entity\User;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 * @property \App\Model\Table\SummariesTable $Summaries
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();

         $this->Auth->allow(['view', 'search']);
    }

    /**
     * IsAuthorized method
     *
     * @param array|null $user The user data
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Allow any action for admin and assistant
        if (User::isAdmin($user['role']) || User::isAssistant($user['role'])) {
            return true;
        }

        // Allow specific actions for publisher
        if (User::isPublisher($user['role'])) {
            $bookId = $this->request->getParam('pass.0');
            $action = $this->request->getParam('action');

            if (in_array($action, ['index', 'add'])) {
                return true;
            }

            if (in_array($action, ['edit', 'delete'])) {
                // Allow Publisher to edit and delete only their books
                if ($bookId) {
                    $book = $this->Books->get($bookId);

                    return $book->user_id === $user['id'];
                }

                return false;
            }
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
        $query = $this->Books->find('byUserRole', ['user' => $user]);
        $books = $this->paginate($query);
        $this->set(compact('books'));
    }

    /**
     * View method
     *
     * @param string|null $id Book id
     * @return void
     */
    public function view($id = null)
    {
        $sessionUser = $this->Auth->user();
        $averageRating = $this->Books->getAverageRating($id);
        $book = $this->Books->get($id, [
            'contain' => ['Users', 'Categories', 'Reviews.Users'],
        ]);

        if (!$sessionUser || User::isMember($sessionUser['role'])) {
            $this->Books->Summaries->logSummary($id);
        }
        $this->set(compact('book', 'sessionUser', 'averageRating'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null
     */
    public function add()
    {
        $book = $this->Books->newEntity();
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $book = $this->Books->patchEntity($book, $data, ['associated' => ['Categories']]);

            // Check if the user is a publisher and set the user_id
            if (User::isPublisher($user['role'])) {
                $book->user_id = $user['id'];
            }

            // Handle cover page upload
            try {
                $book = $this->Books->handleCoverPageUpload($book, $data);
            } catch (\RuntimeException $e) {
                $this->Flash->error($e->getMessage());

                return $this->redirect(['action' => 'index']);
            }

            // Save the book data
            if ($this->Books->save($book, ['associated' => ['Categories']])) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }

        $publisherOptions = $this->Books->Users->find('publishers', ['active' => true])->toArray();
        $categories = $this->Books->Categories->find('activeCategories')->toArray();

        $this->set(compact('book', 'publisherOptions', 'user', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id
     * @return \Cake\Http\Response|void|null
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['Categories', 'Users'],
        ]);
        $user = $this->Auth->user();
        $oldCoverPage = $book->coverpage;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $book = $this->Books->patchEntity($book, $data, ['associated' => ['Categories']]);

            // Handle cover page upload and removal
            try {
                $book = $this->Books->handleCoverPageUpload($book, $data, $oldCoverPage);
            } catch (\RuntimeException $e) {
                $this->Flash->error($e->getMessage());

                return $this->redirect(['action' => 'index']);
            }

            if ($this->Books->save($book, ['associated' => ['Categories']])) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }

        $publisherOptions = $this->Books->Users->find('publishers', ['active' => true])->toArray();
        $categories = $this->Books->Categories->find('activeCategories')->toArray();

        $this->set(compact('book', 'publisherOptions', 'user', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        $coverPage = $book->coverpage;

        if ($this->Books->delete($book)) {
            $this->Books->deleteCoverPage($coverPage);
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Search method
     *
     * @return void
     */
    public function search()
    {
        $sessionUser = $this->Auth->user();
        $this->request->allowMethod(['get']);

        $query = $this->Books
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Users', 'Categories'])
            ->where(['Books.status' => true])
            ->distinct('Books.id');

        // Search options
        $publishers = $this->Books->Users->find('publishers')->toArray();
        $categories = $this->Books->Categories->find('activeCategories')->toArray();

        $books = $this->paginate($query, ['limit' => 6]);

        $this->set(compact('books', 'sessionUser', 'publishers', 'categories'));
    }
}
