<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SummariesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SummariesTable Test Case
 */
class SummariesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SummariesTable
     */
    public $Summaries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Summaries',
        'app.Books',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Summaries') ? [] : ['className' => SummariesTable::class];
        $this->Summaries = TableRegistry::getTableLocator()->get('Summaries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Summaries);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertEquals('summaries', $this->Summaries->getTable());
        $this->assertEquals('id', $this->Summaries->getPrimaryKey());
        $this->assertTrue($this->Summaries->hasBehavior('Timestamp'));
        $this->assertInstanceOf(\Cake\ORM\Association\BelongsTo::class, $this->Summaries->Books);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = new \Cake\Validation\Validator();
        $result = $this->Summaries->validationDefault($validator);

        $this->assertInstanceOf(\Cake\Validation\Validator::class, $result);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $summary = $this->Summaries->newEntity([
            'search_id' => 1,
        ]);

        $result = $this->Summaries->save($summary);
        $this->assertNotFalse($result);

        $invalidSummary = $this->Summaries->newEntity([
            'search_id' => 9999,
        ]);

        $result = $this->Summaries->save($invalidSummary);
        $this->assertFalse($result);
    }

    /**
     * Test logSummary method
     *
     * @return void
     */
    public function testLogSummary()
    {
        // Success Case: Passing existing book from fixture
        $validBookId = 1;
        $result = $this->Summaries->logSummary($validBookId);
        $this->assertTrue($result, 'logSummary should return true on successful save');

        // Failure Case: Passing null as the book ID to trigger a failure
        $invalidBookId = null;
        $result = $this->Summaries->logSummary((int)$invalidBookId);
        $this->assertFalse($result, 'logSummary should return false on failure to save');
    }

    /**
     * Test getTopSearchIds method
     *
     * @return void
     */
    public function testGetTopSearchIds()
    {
        $limit = \App\Model\Entity\Book::TREND_BOOKS_LIMIT;
        $result = $this->Summaries->getTopSearchIds($limit);
        $this->assertTrue(is_array($result), 'The result is an array');
        $this->assertCount($limit, $result, 'The result count should match the limit');
    }
}
