<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Exception;

/**
 * App\Controller\BooksController Test Case
 *
 * @uses \App\Controller\BooksController
 */
class BooksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Books',
        'app.Users',
        'app.BooksCategories',
        'app.Categories',
        'app.Logs',
        'app.Summaries',
        'app.Reviews',
    ];

    /**
     * Set up method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Books = TableRegistry::getTableLocator()->get('Books');
    }

    /**
     * Test index method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testIndex()
    {
        // Test for Admin user
        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->get('/books');
        $this->assertResponseOk();

        // Test for Assistant user
        $this->session(['Auth.User' => ['role' => 'assistant', 'id' => 2]]);
        $this->get('/books');
        $this->assertResponseOk();

        // Test for Publisher user
        $this->session(['Auth.User' => ['role' => 'publisher', 'id' => 3]]);
        $this->get('/books');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @throws Exception
     */
    public function testView()
    {
        // Admin should be able to view any book
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->get('/books/view/1');
        $this->assertResponseOk();

        // Assistant should be able to view any book
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->get('/books/view/1');
        $this->assertResponseOk();

        // Publisher should  be able to view any book
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->get('/books/view/2');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     * @throws Exception
     */
    public function testAdd()
    {
        // Admin can add book and assign publishers only
        $this->session(['Auth' => ['role' => 'admin', 'id' => 1]]);
        $this->post('/books/add', [
            'title' => 'Admin Added Book',
            'user_id' => 3,
        ]);
        $this->assertResponseSuccess();

        // Assistant can add book and assign publishers only
        $this->session(['Auth' => ['role' => 'assistant', 'id' => 2]]);
        $this->post('/books/add', [
            'title' => 'Assistant Added Book',
            'user_id' => 3,
        ]);
        $this->assertResponseSuccess();

        // Publisher can add book and assign as publisher only himself
        $this->session(['Auth' => ['role' => 'publisher', 'id' => 2]]);
        $this->post('/books/add', [
            'title' => 'Publisher Added Book',
            'user_id' => 3,
        ]);
        $this->assertResponseSuccess();
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws Exception
     */
    public function testEdit()
    {
        // Admin user
        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->post('/books/add', [
            'title' => 'Book to Edit',
            'user_id' => 3,
        ]);

        // Fetch the last inserted book from the database
        $book = $this->getTableLocator()->get('Books')->find()->order(['id' => 'DESC'])->first();
        $bookId = $book ? $book->id : null;

        // Ensure the book was created
        $this->assertNotEmpty($bookId);
        $this->assertNotNull($this->Books->get($bookId));

        // Test editing by Admin
        $this->post("/books/edit/$bookId", [
            'title' => 'Edited by Admin',
        ]);
        $this->assertResponseSuccess();
        $editedBook = $this->Books->get($bookId);
        $this->assertEquals('Edited by Admin', $editedBook->title);
    }

    /**
     * Test delete method
     *
     * @return void
     * @throws Exception
     */
    public function testDelete()
    {
        // Admin should be able to delete any book
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->delete('/books/delete/1');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $book = $this->Books->find()->where(['id' => 1])->first();
        $this->assertEmpty($book);

        // Assistant should be able to delete any book
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->delete('/books/delete/2');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $book = $this->Books->find()->where(['id' => 2])->first();
        $this->assertEmpty($book);

        // Publisher should be able to delete his book
        $this->session(['Auth' => ['id' => 3, 'role' => 'publisher']]);
        $this->delete('/books/delete/3');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $book = $this->Books->find()->where(['id' => 6])->first();
        $this->assertEmpty($book);
    }

    /**
     * Test search method
     *
     * @return void
     * @throws Exception
     */
    public function testSearch()
    {
        // Any user should be able to access search (homepage '/')
        $this->get('/');
        $this->assertResponseOk();

        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->get('/');
        $this->assertResponseOk();

        $this->session(['Auth.User' => ['role' => 'assistant', 'id' => 2]]);
        $this->get('/');
        $this->assertResponseOk();

        $this->session(['Auth.User' => ['role' => 'publisher', 'id' => 3]]);
        $this->get('/');
        $this->assertResponseOk();
    }
}
