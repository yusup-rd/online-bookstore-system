<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 *
 * @var string $token
 */
?>

<p>Dear User,</p>
<p>
    Thank you for registering with our online bookstore!
    To complete your registration and activate your account,
    please verify your email address by clicking the button below:
</p>
<p><?= $this->Html->link(
        'Verify Email Address',
        [
            'controller' => 'Users',
            'action' => 'verifyMemberAccount',
            $token,
        ],
        [
            'fullBase' => true,
            'class' => 'button',
        ]
    )?></p>
<p>If you did not register for an account with us, please ignore this email.</p>
<p>Thank you for choosing our bookstore!</p>
