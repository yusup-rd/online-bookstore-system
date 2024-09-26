<?php
/**
 * @var \App\Form\ResetPasswordForm $resetPasswordForm
 */
?>
<div class="form-container">
    <div class="form form-card">
        <div class="form-card-section">
            <h2 class="text-center"><?= __('Reset Your Password') ?></h2>
            <p class="lead text-center"><?= __('Please enter your new password and confirm it to regain access to your account.') ?></p>
            <?= $this->Form->create($resetPasswordForm) ?>
            <?= $this->Form->control('password', [
                'label' => __('New Password'),
            ]) ?>
            <?= $this->Form->control('confirm_password', [
                'type' => 'password',
                'label' => __('Confirm Password'),
            ]) ?>
            <?= $this->Form->button(
                '<i class="fas fa-key"></i> ' . __('Reset Password'),
                ['escapeTitle' => false, 'class' => 'button expanded reset-password-button']
            ) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
