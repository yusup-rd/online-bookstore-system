<?php

namespace App\Test\TestCase\Mailer;

use App\Mailer\UserMailer;
use App\Model\Table\UsersTable;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * UserMailer Test Case
 */
class UserMailerTest extends TestCase
{
    public $fixtures = ['app.Users'];

    /**
     * @var UserMailer
     */
    protected $UserMailer;

    /**
     * @var UsersTable
     */
    protected $Users;

    /**
     * Setup method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->UserMailer = new UserMailer();
    }

    /**
     * Teardown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserMailer, $this->Users);

        parent::tearDown();
    }

    /**
     * Test sendToPublisher method.
     *
     * @return void
     */
    public function testSendToPublisher()
    {
        $to = 'test@example.com';
        $subject = 'Test Subject';
        $message = 'This is a test message.';

        $this->UserMailer->sendToPublisher($to, $subject, $message);

        $email = new Email();
        $email->setTo($to)
            ->setSubject($subject)
            ->setEmailFormat('html')
            ->viewBuilder()
            ->setTemplate('default')
            ->setLayout('default')
            ->setVars([
                'subject' => $subject,
                'message' => $message,
                'senderName' => 'Online Bookstore System',
            ]);

        $this->assertEquals([$to => $to], $this->UserMailer->getTo());
        $this->assertSame($subject, $this->UserMailer->getSubject());
        $this->assertSame('html', $this->UserMailer->getEmailFormat());

        $viewBuilder = $this->UserMailer->viewBuilder();
        $this->assertSame('publisher_notification', $viewBuilder->getTemplate());
        $this->assertSame('default', $viewBuilder->getLayout());
        $vars = $viewBuilder->getVars();
        $this->assertSame([
            'subject' => $subject,
            'message' => $message,
            'senderName' => 'Online Bookstore System',
        ], $vars);
    }

    /**
     * Test sendResetEmail method.
     *
     * @return void
     */
    public function testSendResetEmail()
    {
        $to = 'test@example.com';
        $token = 'unique-token';

        $this->UserMailer->sendResetEmail($to, $token);

        $this->assertEquals([$to => $to], $this->UserMailer->getTo());
        $this->assertSame('Password Reset Request', $this->UserMailer->getSubject());
        $this->assertSame('html', $this->UserMailer->getEmailFormat());

        $viewBuilder = $this->UserMailer->viewBuilder();
        $this->assertSame('forgot_password', $viewBuilder->getTemplate());
        $this->assertSame('default', $viewBuilder->getLayout());
        $vars = $viewBuilder->getVars();
        $this->assertSame([
            'token' => $token,
            'subject' => 'Password Reset Request',
            'senderName' => 'Online Bookstore System',
        ], $vars);
    }

    /**
     * Test sendMemberVerificationEmail method.
     *
     * @return void
     */
    public function testSendMemberVerificationEmail()
    {
        $to = 'testuser@example.com';
        $token = 'verification_token';

        $this->UserMailer->sendMemberVerificationEmail($to, $token);

        $this->assertEquals([$to => $to], $this->UserMailer->getTo());
        $this->assertSame('Account Verification', $this->UserMailer->getSubject());
        $this->assertSame('html', $this->UserMailer->getEmailFormat());

        $viewBuilder = $this->UserMailer->viewBuilder();
        $this->assertSame('registration', $viewBuilder->getTemplate());
        $this->assertSame('default', $viewBuilder->getLayout());
        $vars = $viewBuilder->getVars();
        $this->assertSame([
            'token' => $token,
            'subject' => 'Account Verification',
            'senderName' => 'Online Bookstore System',
        ], $vars);
    }
}
