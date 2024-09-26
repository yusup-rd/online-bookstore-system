<div class="form-container">
    <div class="form-card">
        <div class="form-card-section">
            <h2 class="text-center"><?= __('Login') ?></h2>
            <?= $this->Form->create() ?>
            <?= $this->Form->control('login', [
                'label' => __('Username'),
                'placeholder' => __('Enter your username')
            ]) ?>
            <?= $this->Form->control('password', [
                'label' => __('Password'),
                'placeholder' => __('Enter your password')
            ]) ?>
            <div class="column text-center small-12">
                <?= $this->Html->link(__('Don\'t have an account yet?'),
                    [
                        'action' => 'registerMember',
                    ],
                    [
                        'class' => 'form-link',
                    ]
                ) ?>
                <?= $this->Html->link(__('Forgot Password?'),
                    [
                        'action' => 'forgotPassword',
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
