<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ReviewHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ReviewHelper Test Case
 */
class ReviewHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\ReviewHelper
     */
    public $ReviewHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->ReviewHelper = new ReviewHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReviewHelper);

        parent::tearDown();
    }

    /**
     * Test linkToReviewer method
     *
     * @return void
     */
    public function testLinkToReviewer()
    {
        $user = new \App\Model\Entity\User(['id' => 1, 'name' => 'John Doe']);
        $result = $this->ReviewHelper->linkToReviewer($user);
        $this->assertContains('<a href="/users/view/1">John Doe</a>', $result);

        $result = $this->ReviewHelper->linkToReviewer(null);
        $this->assertEquals('', $result);
    }

    /**
     * Test linkToBook method
     *
     * @return void
     */
    public function testLinkToBook()
    {
        $book = new \App\Model\Entity\Book(['id' => 1, 'title' => 'Sample Book']);
        $result = $this->ReviewHelper->linkToBook($book);
        $this->assertContains('<a href="/books/view/1">Sample Book</a>', $result);

        $result = $this->ReviewHelper->linkToBook(null);
        $this->assertEquals('', $result);

        $result = $this->ReviewHelper->linkToBook($book, 'Custom Label');
        $this->assertContains('<a href="/books/view/1">Custom Label</a>', $result);
    }
}
