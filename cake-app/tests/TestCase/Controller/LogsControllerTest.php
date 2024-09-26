<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Exception;

/**
 * App\Controller\LogsController Test Case
 *
 * @uses \App\Controller\LogsController
 */
class LogsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @throws Exception
     */
    public function testIndex()
    {
        // Test for Admin user
        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->get('/logs');
        $this->assertResponseOk();
    }
}
