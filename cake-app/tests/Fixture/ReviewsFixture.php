<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReviewsFixture
 */
class ReviewsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $import = ['table' => 'reviews'];

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
                'user_id' => 6,
                'book_id' => 1,
                'rating' => 5,
                'comment' => 'An excellent read!',
                'deleted' => null,
                'created' => '2024-09-03 01:49:07',
                'modified' => '2024-09-03 01:49:07',
            ],
            [
                'id' => 2,
                'user_id' => 7,
                'book_id' => 2,
                'rating' => 4,
                'comment' => 'Very informative.',
                'deleted' => null,
                'created' => '2024-09-04 02:50:08',
                'modified' => '2024-09-04 02:50:08',
            ],
            [
                'id' => 3,
                'user_id' => 8,
                'book_id' => 3,
                'rating' => 3,
                'comment' => 'Good, but could be better.',
                'deleted' => null,
                'created' => '2024-09-05 03:51:09',
                'modified' => '2024-09-05 03:51:09',
            ],
        ];
        parent::init();
    }
}
