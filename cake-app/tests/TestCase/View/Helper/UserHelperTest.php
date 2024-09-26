<?php

namespace App\Test\TestCase\View\Helper;

use App\Model\Entity\User;
use App\View\Helper\UserHelper;
use Cake\TestSuite\TestCase;
use Cake\View\Helper\FormHelper;
use Cake\View\View;

/**
 * App\View\Helper\UserHelper Test Case
 */
class UserHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\UserHelper
     */
    protected $UserHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->UserHelper = new UserHelper($view);
        $this->FormHelper = new FormHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserHelper, $this->FormHelper);

        parent::tearDown();
    }

    /**
     * Test displayRoleInput method
     *
     * @return void
     */
    public function testDisplayRoleInput()
    {
        // Test for Admin role
        $sessionUser = ['role' => User::ROLE_ADMIN];
        $result = $this->UserHelper->displayRoleInput($sessionUser);
        $this->assertContains('<select name="role"', $result);
        $this->assertContains('<option value="' . User::ROLE_ADMIN . '">', $result);

        // Test for Assistant role
        $sessionUser = ['role' => User::ROLE_ASSISTANT];
        $result = $this->UserHelper->displayRoleInput($sessionUser);
        $this->assertContains('<select name="role"', $result);
        $this->assertRegExp('/<option value="' . User::ROLE_PUBLISHER . '".*?>Publisher<\/option>/', $result);
    }

    /**
     * Test displayStatusInput method
     *
     * @return void
     */
    public function testDisplayStatusInput()
    {
        // Test for Admin role
        $sessionUser = ['role' => User::ROLE_ADMIN];
        $result = $this->UserHelper->displayStatusInput($sessionUser);
        $this->assertContains('<select name="status"', $result);

        // Test for non-admin role
        $sessionUser = ['role' => User::ROLE_ASSISTANT];
        $result = $this->UserHelper->displayStatusInput($sessionUser);
        $this->assertEmpty($result);
    }
}
