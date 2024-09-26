<?php
namespace App\Test\TestCase\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Exception;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
    ];

    /**
     * Set up method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    /**
     * Test login method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testLogin()
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->newEntity([
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'status' => 1,
            'role' => 'member',
        ]);
        $users->save($user);

        $data = [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ];
        $this->post('/users/login', $data);
        $this->assertResponseSuccess();
    }

    /**
     * Test logout method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testLogout()
    {
        $this->get('/users/logout');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertFlashMessage('You are now logged out.');
    }

    /**
     * Test index method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testIndex()
    {
        // Admin should be able to access the index
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->get('/users');
        $this->assertResponseOk();

        // Assistant should be able to access the index but see only Publishers
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->get('/users');
        $this->assertResponseOk();

        // Publisher should be able to access the index
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->get('/users');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws Exception
     */
    public function testView()
    {
        // Admin should be able to view any user
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->get('/users/view/1');
        $this->assertResponseOk();

        // Assistant should be able to view Publishers only
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->get('/users/view/3'); // Assuming user with id 3 is a Publisher
        $this->assertResponseOk();

        $this->get('/users/view/1'); // Assuming user with id 1 is an Admin
        $this->assertRedirect();
        $this->assertFlashMessage('You are not authorized to access that location.');

        // Publisher should  be able to view himself only
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->get('/users/view/3'); // Own account
        $this->assertResponseOk();

        $this->get('/users/view/1'); // Different user
        $this->assertRedirect();
        $this->assertFlashMessage('You are not authorized to access that location.');
    }

    /**
     * Test add method
     *
     * @return void
     * @throws Exception
     */
    public function testAdd()
    {
        // Admin should be able to add any user
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->enableCsrfToken();
        $data = [
            'login' => 'adminaddeduser',
            'password' => (new DefaultPasswordHasher())->hash('adminpassword'),
            'role' => 'publisher',
            'name' => 'Admin Added User',
            'address' => 'Admin Address',
            'phone' => '5555555555',
            'fax' => '5555555555',
            'email' => 'adminaddeduser@example.com',
            'url' => 'https://adminaddeduser.com',
            'status' => 1,
        ];
        $this->post('/users/add', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $this->assertNotEmpty($this->Users->find()->where(['login' => 'adminaddeduser'])->first());
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testEdit()
    {
        // Admin should be able to edit any user
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $data = [
            'login' => 'adminediteduser',
            'name' => 'Admin Edited User',
            'address' => 'Admin Address Edited',
            'phone' => '5555555556',
            'fax' => '5555555556',
            'email' => 'adminediteduser@example.com',
            'url' => 'https://adminediteduser.com',
            'status' => 1,
        ];
        $this->put('/users/edit/2', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $user = $this->Users->get(2);
        $this->assertEquals('adminediteduser', $user->login);
        $this->assertEquals('Admin Edited User', $user->name);
    }

    /**
     * Test delete method
     *
     * @return void
     * @throws Exception
     */
    public function testDelete()
    {
        // Admin should be able to delete any user
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->delete('/users/delete/2');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $user = $this->Users->find()->where(['id' => 2])->first();
        $this->assertEmpty($user);

        // No other user can delete anyone
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->delete('/users/delete/4');
        $this->assertRedirect();
        $this->assertFlashMessage('You are not authorized to access that location.');
    }

    /**
     * Test mail method
     *
     * @return void
     * @throws Exception
     */
    public function testMail()
    {
        // Test admin
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->get('/users/mail/3');
        $this->assertResponseOk();

        $this->assertResponseContains('Submit');

        // Test assistant access
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->get('/users/mail/3');
        $this->assertResponseOk();

        $this->assertResponseContains('Submit');

        // Test publisher access
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->get('/users/mail');
        $this->assertRedirect();
        $this->assertResponseCode(302);
    }

    /**
     * Test forgotPassword method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testForgotPassword()
    {
        $this->post('/users/forgot-password', ['email' => 'existinguser@example.com']);
        $this->assertResponseSuccess();
    }

    /**
     * Test resetPassword method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testResetPassword()
    {
        $this->get('/users/reset-password');
        $this->assertResponseCode(302);
        $this->assertRedirect('/users/login');
        $this->assertFlashMessage('Invalid token.');
    }

    /**
     * Test register member method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testRegisterMember()
    {
        $data = [
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
            'status' => 0,
            'role' => 'member',
        ];

        $this->post('/users/registerMember', $data);

        $this->assertResponseSuccess();
    }

    /**
     * Test verify member account method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testVerifyMemberAccount()
    {
        // Scenario 1: Valid token and successful verification
        $this->get('/users/verifyMemberAccount/member_token_123');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertFlashMessage('Your account has been successfully verified. You can now log in.');

        // Scenario 2: Invalid or expired token
        $this->get('/users/verifyMemberAccount/invalid_token');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertFlashMessage('Invalid or expired token.');
    }

    /**
     * Test updatePassword method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testUpdatePassword()
    {
        // Admin
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'role' => 'admin',
                ],
            ],
        ]);
        $this->post('/users/updatePassword/1', [
            'password' => 'newAdminPassword',
            'password_confirm' => 'newAdminPassword',
        ]);
        $this->assertResponseSuccess();

        // Assistant
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'role' => 'assistant',
                ],
            ],
        ]);
        $this->post('/users/updatePassword/2', [
            'password' => 'newAssistantPassword',
            'password_confirm' => 'newAssistantPassword',
        ]);
        $this->assertResponseSuccess();

        // Publisher
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 3,
                    'role' => 'publisher',
                ],
            ],
        ]);
        $this->post('/users/updatePassword/3', [
            'password' => 'newPublisherPassword',
            'password_confirm' => 'newPublisherPassword',
        ]);
        $this->assertResponseSuccess();

        // Member
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 6,
                    'role' => 'member',
                ],
            ],
        ]);
        $this->post('/users/updatePassword/4', [
            'password' => 'newMemberPassword',
            'password_confirm' => 'newMemberPassword',
        ]);
        $this->assertResponseSuccess();
    }
}
