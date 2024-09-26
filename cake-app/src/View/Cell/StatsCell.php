<?php
namespace App\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Stats cell
 *
 * @property \App\Model\Table\BooksTable|\Cake\ORM\Table $Books
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Table $Users
 * @property \App\Model\Table\SummariesTable|\Cake\ORM\Table $Summaries
 */
class StatsCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Books = TableRegistry::getTableLocator()->get('Books');
        $this->Summaries = TableRegistry::getTableLocator()->get('Summaries');
    }

    /**
     * topBook method
     *
     * @return void
     */
    private function topBook()
    {
        $topBookSummary = $this->Summaries->find()
            ->select(['search_id', 'count' => 'COUNT(search_id)'])
            ->group('search_id')
            ->order(['count' => 'DESC'])
            ->first();

        $topBook = null;
        $topBookId = null;

        if ($topBookSummary) {
            $topBookId = $topBookSummary->search_id;
            $topBook = $this->Books->get($topBookId);
        }

        $this->set(compact('topBook', 'topBookId'));
    }

    /**
     * totalPublishers method
     *
     * @return void
     */
    private function totalPublishers()
    {
        $publishersCount = $this->Users->find()
            ->where(['role' => 'publisher'])
            ->count();

        $this->set(compact('publishersCount'));
    }

    /**
     * topPublisher method
     *
     * @return void
     */
    private function topPublisher()
    {
        $this->topBook();

        $topBook = isset($this->viewVars['topBook']) ? $this->viewVars['topBook'] : null;
        $publisher = null;

        if ($topBook) {
            $publisher = $this->Users->get($topBook->user_id);
        }

        $this->set(compact('publisher'));
    }

    /**
     * Total books method
     *
     * @return void
     */
    private function totalBooks()
    {
        $totalBooks = $this->Books->find()
            ->where(['status' => true])
            ->count();

        $this->set(compact('totalBooks'));
    }

    /**
     * Display method
     *
     * @return void
     */
    public function display()
    {
        $this->topBook();
        $this->topPublisher();
        $this->totalBooks();
        $this->totalPublishers();
    }
}
