<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BooksCategoriesFixture
 */
class BooksCategoriesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'books_categories'];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'book_id' => 1,
                'category_id' => 1,
            ],
            [
                'id' => 2,
                'book_id' => 2,
                'category_id' => 2,
            ],
        ];
        parent::init();
    }
}
