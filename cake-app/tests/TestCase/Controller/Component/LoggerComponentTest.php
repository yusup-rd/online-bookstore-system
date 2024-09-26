<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\LoggerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\LoggerComponent Test Case
 */
class LoggerComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\LoggerComponent
     */
    public $Logger;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Logger = new LoggerComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logger);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        // Check if the Logger component is an instance of LoggerComponent
        $this->assertInstanceOf(LoggerComponent::class, $this->Logger);
    }
}
