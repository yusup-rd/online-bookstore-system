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

<p>A password reset has been requested for your account.</p>
<p>If this was you, please click the link below to reset your password:</p>
<p><?= $this->Html->link(
        'Reset Password Link',
        [
            'controller' => 'Users',
            'action' => 'resetPassword',
            $token,
        ],
        ['fullBase' => true]
    )?></p>
<p>If you did not request this, please ignore this email.</p>
<p>Thank you.</p>
