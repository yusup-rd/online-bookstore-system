<?php
namespace App\Test\TestCase\View\Helper;

use App\Model\Entity\Book;
use App\View\Helper\BookHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class BookHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\BookHelper
     */
    public $BookHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->BookHelper = new BookHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BookHelper);
        parent::tearDown();
    }

    /**
     * Test getSearchClass method
     *
     * @return void
     */
    public function testGetSearchClass()
    {
        // Test when the user is logged in
        $sessionUser = ['id' => 1, 'role' => 'admin'];
        $result = $this->BookHelper->getSearchClass($sessionUser);
        $this->assertEquals('books index large-9 medium-8 columns content', $result);

        // Test when the user is not logged in
        $result = $this->BookHelper->getSearchClass((array)null);
        $this->assertEquals('books index large-12 medium-12 columns content', $result);
    }

    /**
     * Test getCoverImage method
     *
     * @return void
     */
    public function testGetCoverImage()
    {
        $book = new Book(['coverpage' => 'example.jpg', 'coverpage_path' => '/path/to/coverpage/example.jpg', 'title' => 'Test Book']);
        $result = $this->BookHelper->getCoverImage($book);
        $this->assertEquals('/img/coverpage/cover_missing.jpg', $result['url']);
        $this->assertEquals('No Cover Page', $result['alt']);
    }

    /**
     * Test getCategoryList method
     *
     * @return void
     */
    public function testGetCategoryList()
    {
        // Test when the book has categories
        $book = new Book(['categories' => [['name' => 'Fiction'], ['name' => 'Adventure']]]);
        $result = $this->BookHelper->getCategoryList($book);
        $this->assertEquals('Fiction, Adventure', $result);

        // Test when the book has no categories
        $book = new Book([]);
        $result = $this->BookHelper->getCategoryList($book);
        $this->assertEquals('No category assigned', $result);
    }

    /**
     * Test displayCoverPage method
     *
     * @return void
     */
    public function testDisplayCoverPage()
    {
        $book = new Book([
            'coverpage' => 'cover.jpg',
            'coverpage_path' => '/path/to/cover.jpg',
        ]);
        $result = $this->BookHelper->displayCoverPage($book);
        $this->assertNotEmpty($result);
    }

    /**
     * Test renderPublisherSelect method
     *
     * @return void
     */
    public function testRenderPublisherSelect()
    {
        $user = ['role' => 'admin'];
        $publisherOptions = [
            1 => 'Publisher 1',
            2 => 'Publisher 2',
        ];
        $result = $this->BookHelper->renderPublisherSelect($user, $publisherOptions);

        $this->assertRegExp('/<select\s+name="user_id"/', $result);
        $this->assertRegExp('/Publisher 1/', $result);
        $this->assertRegExp('/Publisher 2/', $result);

        $user = ['role' => 'publisher'];
        $result = $this->BookHelper->renderPublisherSelect($user, $publisherOptions);

        $this->assertEmpty($result);
    }

    /**
     * Test the displayUserName method.
     *
     * @return void
     */
    public function testDisplayUserName()
    {
        $book = new Book([
            'user' => (object)[
                'name' => 'John Doe',
                'id' => 1,
            ],
        ]);
        $sessionUser = ['role' => 'admin'];
        $result = $this->BookHelper->displayUserName($book, $sessionUser);

        $this->assertContains('<a href="/users/view/1">John Doe</a>', $result);

        $sessionUser['role'] = 'publisher';
        $result = $this->BookHelper->displayUserName($book, $sessionUser);

        $this->assertEquals('John Doe', $result);
    }
}
