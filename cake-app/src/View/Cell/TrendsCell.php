<?php
namespace App\View\Cell;

use App\Model\Entity\Book;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Trends cell
 *
 * @property \App\Model\Table\BooksTable|\Cake\ORM\Table $Books
 * @property \App\Model\Table\SummariesTable|\Cake\ORM\Table $Summaries
 */
class TrendsCell extends Cell
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
        $this->Books = TableRegistry::getTableLocator()->get('Books');
        $this->Summaries = TableRegistry::getTableLocator()->get('Summaries');
    }

    /**
     * trendingBooks method
     *
     * @return void
     */
    private function trendingBooks()
    {
        $summariesCount = $this->Summaries->find()->count();

        if ($summariesCount > 0) {
            $topSearchIds = $this->Summaries->getTopSearchIds(Book::TREND_BOOKS_LIMIT);

            $trendingBooks = $this->Books->find()
                ->where(['Books.id IN' => $topSearchIds])
                ->order(['FIELD(Books.id, ' . implode(',', $topSearchIds) . ')'])
                ->all()
                ->toArray();

            $this->set(compact('trendingBooks'));
        } else {
            $this->set('trendingBooks', []);
        }
    }

    /**
     * latestBooks method
     *
     * @return void
     */
    private function latestBooks()
    {
        $latestBooks = $this->Books->find('all', [
            'order' => ['Books.created' => 'DESC'],
            'limit' => Book::TREND_BOOKS_LIMIT,
        ])->all()->toArray();

        $this->set(compact('latestBooks'));
    }

    /**
     * topRatedBooks method
     *
     * @return void
     */
    private function topRatedBooks()
    {
        $topRatedBooks = $this->Books->Reviews->find('averageRating')
            ->order(['average_rating' => 'DESC'])
            ->contain([
                'Books' => function (Query $query) {
                    return $query->enableAutoFields();
                },
            ])
            ->limit(Book::TREND_BOOKS_LIMIT)
            ->extract('book');

        $this->set(compact('topRatedBooks'));
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->trendingBooks();
        $this->latestBooks();
        $this->topRatedBooks();
    }
}
