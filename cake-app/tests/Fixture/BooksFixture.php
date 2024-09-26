<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BooksFixture
 */
class BooksFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'books'];
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
                'user_id' => 3,
                'title' => 'The Great Gatsby',
                'isbn' => '9780743273565',
                'author' => 'F. Scott Fitzgerald',
                'synopsis' => 'A novel set in the Roaring Twenties.',
                'coverpage' => 'cover_gatsby.jpg',
                'url' => 'https://example.com/gatsby',
                'status' => 1,
                'deleted' => null,
                'created' => '2024-07-22 03:50:44',
                'modified' => '2024-07-22 03:50:44',
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'title' => 'To Kill a Mockingbird',
                'isbn' => '9780061120084',
                'author' => 'Harper Lee',
                'synopsis' => 'A novel about racial injustice in the Deep South.',
                'coverpage' => 'cover_mockingbird.jpg',
                'url' => 'https://example.com/mockingbird',
                'status' => 0,
                'deleted' => null,
                'created' => '2024-07-22 03:50:44',
                'modified' => '2024-07-22 03:50:44',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'title' => 'The Hobbit',
                'isbn' => '9780061120084',
                'author' => 'Author',
                'synopsis' => 'Book descriptions',
                'coverpage' => 'image.jpg',
                'url' => 'https://example.com/book',
                'status' => 0,
                'deleted' => null,
                'created' => '2024-07-22 03:50:44',
                'modified' => '2024-07-22 03:50:44',
            ],
        ];
        parent::init();
    }
}
