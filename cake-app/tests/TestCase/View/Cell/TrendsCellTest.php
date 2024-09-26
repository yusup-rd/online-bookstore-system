<?php
namespace App\Test\TestCase\View\Cell;

use App\Model\Table\BooksTable;
use App\Model\Table\SummariesTable;
use App\View\Cell\TrendsCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * App\View\Cell\TrendsCell Test Case
 */
class TrendsCellTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Books',
        'app.Summaries',
    ];

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
     * @var \App\View\Cell\TrendsCell
     */
    public $Trends;

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
        $this->Trends = new TrendsCell($this->request, $this->response);
        $this->Trends->initialize();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Trends);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(BooksTable::class, $this->Trends->Books);
        $this->assertInstanceOf(SummariesTable::class, $this->Trends->Summaries);
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->Trends->display();

        $trendingBooks = isset($this->Trends->viewVars['trendingBooks']) ? $this->Trends->viewVars['trendingBooks'] : null;
        $latestBooks = isset($this->Trends->viewVars['latestBooks']) ? $this->Trends->viewVars['latestBooks'] : null;
        $topRatedBooks = isset($this->Trends->viewVars['topRatedBooks']) ? $this->Trends->viewVars['topRatedBooks'] : null;

        $this->assertNotNull($trendingBooks, 'Trending books should not be null.');
        $this->assertNotEmpty($trendingBooks, 'Trending books should not be empty.');
        $this->assertNotEmpty($latestBooks, 'Latest books should not be empty.');
        $this->assertNotEmpty($topRatedBooks, 'Top Rated books should not be empty.');
    }
}
