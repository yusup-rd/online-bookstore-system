<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogsTable Test Case
 */
class LogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogsTable
     */
    public $Logs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Logs',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Logs') ? [] : ['className' => LogsTable::class];
        $this->Logs = TableRegistry::getTableLocator()->get('Logs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logs);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(LogsTable::class, $this->Logs);
        $this->assertEquals('logs', $this->Logs->getTable());
        $this->assertTrue($this->Logs->hasBehavior('Timestamp'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = $this->Logs->getValidator('default');

        $this->assertNotEmpty($validator->field('url'));
        $this->assertNotEmpty($validator->field('ip_address'));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $log = $this->Logs->newEntity([
            'user_id' => 1,
            'url' => '/example-url',
            'ip_address' => '127.0.0.1',
        ]);

        // Assuming user_id 1 exists in the Users table
        $this->Logs->save($log);
        $this->assertEmpty($log->getErrors());

        // Testing with a non-existent user_id
        $log = $this->Logs->newEntity([
            'user_id' => 9999, // Assuming this user_id does not exist
            'url' => '/example-url',
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertFalse($this->Logs->save($log));
        $this->assertNotEmpty($log->getErrors());
        $this->assertArrayHasKey('_existsIn', $log->getErrors()['user_id']);
    }
}
