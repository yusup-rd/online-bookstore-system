<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Book;
use App\Model\Table\BooksTable;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BooksTable Test Case
 */
class BooksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BooksTable
     */
    public $Books;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Books',
        'app.Users',
        'app.Reviews',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Books') ? [] : ['className' => BooksTable::class];
        $this->Books = TableRegistry::getTableLocator()->get('Books', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Books);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(BooksTable::class, $this->Books);
        $this->assertEquals('books', $this->Books->getTable());
        $this->assertTrue($this->Books->hasBehavior('Timestamp'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = $this->Books->getValidator('default');

        $this->assertNotEmpty($validator->field('title'));
        $this->assertNotEmpty($validator->field('author'));
        $this->assertNotEmpty($validator->field('isbn'));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Attempt to save a book with a valid user_id
        $validBook = $this->Books->newEntity([
            'title' => 'Valid Book',
            'author' => 'Author Name',
            'user_id' => 3,
            'isbn' => '1234567890123',
            'status' => 1,
        ]);

        $result = $this->Books->save($validBook);
        $this->assertNotFalse($result, 'Valid book should be saved');

        // Attempt to save a book with an invalid user_id
        $invalidBook = $this->Books->newEntity([
            'title' => 'Invalid Book',
            'author' => 'Author Name',
            'user_id' => 999,
            'isbn' => '1234567890123',
            'status' => 1,
        ]);

        $result = $this->Books->save($invalidBook);
        $this->assertFalse($result, 'Invalid book should not be saved');
    }

    /**
     * Test findByUserRole method
     *
     * @return void
     */
    public function testFindByUserRole()
    {
        $user = ['id' => 3, 'role' => 'publisher'];
        $query = $this->Books->find('byUserRole', ['user' => $user]);

        $this->assertInstanceOf(Query::class, $query);
        $books = $query->toArray();
        foreach ($books as $book) {
            $this->assertEquals($user['id'], $book->user_id, 'Books should belong to the user');
        }

        // Test for admin role
        $user = ['id' => 1, 'role' => 'admin'];
        $query = $this->Books->find('byUserRole', ['user' => $user]);

        $this->assertInstanceOf(Query::class, $query);
        $books = $query->toArray();
        $this->assertNotEmpty($books, 'Admin should see all books');
    }

    /**
     * Test deleteCoverPage method
     *
     * @return void
     */
    public function testDeleteCoverPage()
    {
        $coverPage = 'test_image.jpg';
        $dir = new Folder(Book::COVER_PAGE_DIR, true, 0777);
        $file = new File($dir->path . DS . $coverPage, true, 0777);
        $file->create();
        $file->write('dummy content');
        $file->close();

        $this->assertTrue($file->exists(), 'File should exist before deletion');

        $this->Books->deleteCoverPage($coverPage);

        $this->assertFalse($file->exists(), 'File should be deleted');
    }

    /**
     * Test handleCoverPageUpload method
     *
     * @return void
     */
    public function testHandleCoverPageUpload()
    {
        $data = [
            'coverpage' => [
                'name' => 'test_image.jpg',
                'tmp_name' => tempnam(sys_get_temp_dir(), 'upl'),
            ],
        ];

        $book = $this->Books->newEntity([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'isbn' => '1234567890',
            'status' => 1,
        ]);

        $book = $this->Books->handleCoverPageUpload($book, $data);

        $this->assertNotEmpty($book->coverpage);
        $this->assertContains('test_image_', $book->coverpage);

        // Test cover page removal
        $data = ['remove_coverpage' => true];
        $book = $this->Books->handleCoverPageUpload($book, $data);
        $this->assertEquals('cover_missing.jpg', $book->coverpage);

        // Test existing cover page handling
        $data = ['current_coverpage' => 'existing_image.jpg'];
        $book = $this->Books->handleCoverPageUpload($book, $data);
        $this->assertEquals('existing_image.jpg', $book->coverpage);
    }

    /**
     * Test getCoverImage method
     *
     * @return void
     */
    public function testGetAverageRating()
    {
        $bookId = 1;
        $averageRating = $this->Books->getAverageRating($bookId);

        $this->assertNotNull($averageRating);
        $this->assertInternalType('float', $averageRating);
    }
}
