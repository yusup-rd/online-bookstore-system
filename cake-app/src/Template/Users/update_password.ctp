<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="form-container">
    <div class="form form-card">
        <div class="form-card-section">
            <h2 class="text-center"><?= __('Change Your Password') ?></h2>
            <p class="lead text-center"><?= __('Please enter your current password, new password and confirm it to change it.') ?></p>
            <?= $this->Form->create($user, ['novalidate' => true]) ?>
            <?= $this->Form->control('current_password', [
                'type' => 'password',
                'required' => true,
                'label' => __('Current Password'),
            ]) ?>
            <?= $this->Form->control('password', [
                'type' => 'password',
                'value' => '',
                'label' => __('New Password'),
            ]) ?>
            <?= $this->Form->control('confirm_password', [
                'type' => 'password',
                'label' => __('Confirm Password'),
            ]) ?>
            <?= $this->element('footer_buttons') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
