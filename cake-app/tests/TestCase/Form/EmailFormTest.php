<?php
namespace App\Test\TestCase\Form;

use App\Form\EmailForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\EmailForm Test Case
 */
class EmailFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\EmailForm
     */
    public $Email;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Email = new EmailForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Email);

        parent::tearDown();
    }

    /**
     * Test validation
     *
     * @return void
     */
    public function testValidation()
    {
        $data = [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ];
        $this->assertTrue($this->Email->validate($data));
    }
}
