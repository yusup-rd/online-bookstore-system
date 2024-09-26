<?php
namespace App\Test\TestCase\Form;

use App\Form\ResetPasswordForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ResetPasswordForm Test Case
 */
class ResetPasswordFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\ResetPasswordForm
     */
    public $ResetPassword;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ResetPassword = new ResetPasswordForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResetPassword);

        parent::tearDown();
    }

    /**
     * Test form validation with different data scenarios
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $form = new ResetPasswordForm();
        $data = [
            'password' => 'password123',
            'confirm_password' => 'password123',
        ];
        $form->setData($data);
        $errors = $form->getErrors();
        $this->assertEmpty($errors, 'Form should be valid with matching passwords.');
    }
}
