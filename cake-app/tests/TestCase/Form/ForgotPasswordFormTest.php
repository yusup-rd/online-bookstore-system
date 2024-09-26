<?php
namespace App\Test\TestCase\Form;

use App\Form\ForgotPasswordForm;
use Cake\TestSuite\TestCase;

class ForgotPasswordFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\ForgotPasswordForm
     */
    public $ForgotPassword;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ForgotPassword = new ForgotPasswordForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ForgotPassword);
        parent::tearDown();
    }

    /**
     * Test form validation with different data scenarios
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $form = new ForgotPasswordForm();
        $data = ['email' => 'email@example.com'];
        $form->setData($data);
        $errors = $form->getErrors();
        $this->assertTrue(is_array($errors), 'Errors should be an array.');
        $this->assertEmpty($errors, 'Form should be valid with a correct email address.');
    }
}
