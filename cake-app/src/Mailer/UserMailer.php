<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    /**
     * sendToPublisher method configures and returns an email object.
     *
     * @param string $to Recipient's email address
     * @param string $subject Subject of the email
     * @param string $message Message body of the email
     * @return void
     */
    public function sendToPublisher($to, $subject, $message)
    {
        $this->setTo($to)
            ->setSubject($subject)
            ->setEmailFormat('html')
            ->viewBuilder()
            ->setTemplate('publisher_notification')
            ->setLayout('default')
            ->setVars([
                'subject' => $subject,
                'message' => $message,
                'senderName' => __('Online Bookstore System'),
            ]);
    }

    /**
     * sendResetEmail method.
     *
     * @param string $to The recipient's email address.
     * @param string $token The token.
     * @return void
     */
    public function sendResetEmail($to, $token)
    {
        $this->setTo($to)
            ->setSubject(__('Password Reset Request'))
            ->setEmailFormat('html')
            ->viewBuilder()
            ->setTemplate('forgot_password')
            ->setLayout('default')
            ->setVars([
                'token' => $token,
                'subject' => __('Password Reset Request'),
                'senderName' => __('Online Bookstore System'),
            ]);
    }

    /**
     * sendMemberVerificationEmail method for member users registration.
     *
     * @param string $to The recipient's email address.
     * @param string $token The token.
     * @return void
     */
    public function sendMemberVerificationEmail($to, $token)
    {
        $this->setTo($to)
            ->setSubject(__('Account Verification'))
            ->setEmailFormat('html')
            ->viewBuilder()
            ->setTemplate('registration')
            ->setLayout('default')
            ->setVars([
                'token' => $token,
                'subject' => __('Account Verification'),
                'senderName' => __('Online Bookstore System'),
            ]);
    }
}
