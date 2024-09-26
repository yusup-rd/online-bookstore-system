<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\User;

?>

<div class="form-container">
    <div class="form-card">
        <div class="form-card-section form">
            <h2 class="text-center"><?= __('Register') ?></h2>
            <?= $this->Form->create($user, ['novalidate' => true]) ?>
            <div style="display: flex;">
                <div class="row" style="margin-right: 20px;">
                    <?= $this->Form->control('name',
                        [
                            'label' => 'Full Name',
                            'placeholder' => __('Enter your full name'),
                        ]
                    ) ?>
                    <?= $this->Form->control('login', [
                        'label' => __('Username'),
                        'placeholder' => __('Enter your username'),
                    ]) ?>
                </div>

                <div class="row">
                    <?= $this->Form->control('password', [
                        'label' => __('Password'),
                        'placeholder' => __('Enter your password'),
                    ]) ?>
                    <?= $this->Form->control('confirm_password', [
                        'type' => 'password',
                        'label' => __('Confirm Password'),
                        'placeholder' => __('Confirm your password'),
                        'required' => true,
                    ]) ?>
                </div>
            </div>

            <?= $this->Form->control('email', ['placeholder' => __('Enter your email')]) ?>
            <?= $this->Form->hidden('role', ['value' => User::ROLE_MEMBER]) ?>
            <?= $this->Form->hidden('status', ['value' => User::STATUS_INACTIVE]) ?>
            <div class="column text-center small-12">
                <?= $this->Html->link(__('Already have an account?'),
                    [
                        'action' => 'login',
                    ],
                    [
                        'class' => 'form-link',
                    ]
                ) ?>
            </div>
            <?= $this->element('footer_buttons') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
