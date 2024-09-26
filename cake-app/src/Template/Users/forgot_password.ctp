<?php
/**
 * @var \App\Form\ForgotPasswordForm $forgotPasswordForm
 */
?>
<div class="form-container">
    <div class="form form-card">
        <div class="form-card-section">
            <h2 class="text-center"><?= __('Forgot Your Password?') ?></h2>
            <p class="lead text-center"><?= __('Enter your email address below, and we\'ll send you a password reset link.') ?></p>
            <?= $this->Form->create($forgotPasswordForm) ?>
            <?= $this->Form->control('email', [
                'type' => 'email',
                'label' => false,
                'placeholder' => __('Enter your email address'),
            ]) ?>
            <?= $this->element('footer_buttons') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
