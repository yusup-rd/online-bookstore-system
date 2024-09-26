<?php
namespace App\Test\TestCase\View\Cell;

use App\Model\Entity\Book;
use App\Model\Entity\User;
use App\View\Cell\StatsCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * App\View\Cell\StatsCell Test Case
 */
class StatsCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var \Cake\Http\ServerRequest|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \App\View\Cell\StatsCell
     */
    public $Stats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Books',
        'app.Users',
        'app.Summaries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(ServerRequest::class)->getMock();
        $this->response = $this->getMockBuilder(Response::class)->getMock();
        $this->Stats = new StatsCell($this->request, $this->response);
        $this->Stats->initialize();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stats);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertNotNull($this->Stats->Users);
        $this->assertNotNull($this->Stats->Books);
        $this->assertNotNull($this->Stats->Summaries);
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->Stats->display();
        $viewVars = $this->Stats->viewVars;

        // Assertions for topBook
        $this->assertArrayHasKey('topBook', $viewVars);
        $this->assertInstanceOf(Book::class, isset($viewVars['topBook']) ? $viewVars['topBook'] : null);

        // Assertions for topPublisher
        $this->assertArrayHasKey('publisher', $viewVars);
        $this->assertInstanceOf(User::class, isset($viewVars['publisher']) ? $viewVars['publisher'] : null);

        // Assertions for totalBooks
        $this->assertArrayHasKey('totalBooks', $viewVars);
        $this->assertInternalType('int', $viewVars['totalBooks']);

        // Assertions for totalPublishers
        $this->assertArrayHasKey('publishersCount', $viewVars);
        $this->assertInternalType('int', $viewVars['publishersCount']);
    }
}
