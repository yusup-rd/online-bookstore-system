<?php

use App\Model\Entity\User;

$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
?>

<div class="footer-buttons">
    <?php if (isset($authUser)): ?>
        <?php if (in_array($action, ['add', 'edit', 'mail', 'updatePassword'])): ?>
            <?= $this->Form->button(
                '<i class="fas fa-check"></i> ' . __('Submit'),
                ['style' => 'text-transform: none;', 'escapeTitle' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                ['action' => 'index'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
        <?php elseif ($action === 'view' && $controller === 'Reviews'): ?>
            <?php if ($authUser['role'] === User::ROLE_MEMBER): ?>
                <?= $this->Html->link(
                    '<i class="fas fa-edit"></i> ' . __('Edit'),
                    [
                        'action' => 'edit',
                        $this->request->getParam('pass.0'),
                    ],
                    [
                        'class' => 'button right',
                        'escapeTitle' => false,
                    ]
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                ['action' => 'index'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
        <?php elseif ($action === 'view'): ?>
            <?php if ($authUser['role'] === User::ROLE_MEMBER): ?>
                <?php if ($controller === 'Books'): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-star"></i> ' . __('Review'),
                        [
                            'controller' => 'Reviews',
                            'action' => 'add',
                            $this->request->getParam('pass.0'),
                        ],
                        [
                            'class' => 'button right',
                            'escapeTitle' => false,
                        ]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                        ['controller' => 'Books', 'action' => 'search'],
                        ['class' => 'button', 'escapeTitle' => false]
                    ) ?>
                <?php elseif ($controller === 'Users'): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-edit"></i> ' . __('Edit'),
                        [
                            'action' => 'edit',
                            $this->request->getParam('pass.0'),
                        ],
                        [
                            'class' => 'button right',
                            'escapeTitle' => false,
                        ]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                        ['controller' => 'Users', 'action' => 'index'],
                        ['class' => 'button', 'escapeTitle' => false]
                    ) ?>
                <?php elseif ($controller === 'Reviews'): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                        ['controller' => 'Reviews', 'action' => 'index'],
                        ['class' => 'button', 'escapeTitle' => false]
                    ) ?>
                <?php endif; ?>
            <?php else: ?>
                <?= $this->Html->link(
                    '<i class="fas fa-edit"></i> ' . __('Edit'),
                    [
                        'action' => 'edit',
                        $this->request->getParam('pass.0'),
                    ],
                    [
                        'class' => 'button right',
                        'escapeTitle' => false,
                    ]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                    ['action' => 'index'],
                    ['class' => 'button', 'escapeTitle' => false]
                ) ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($action === 'forgotPassword'): ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> ' . __('Back'),
                ['action' => 'login'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fas fa-paper-plane"></i> ' . __('Submit'),
                ['class' => 'right', 'style' => 'text-transform: capitalize;', 'escapeTitle' => false]
            ) ?>
        <?php elseif ($action === 'login'): ?>
            <?= $this->Html->link(
                '<i class="fas fa-home"></i> ' . __('Home'),
                ['controller' => 'Books', 'action' => 'search'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fas fa-sign-in-alt"></i> ' . __('Login'),
                ['class' => 'right', 'escapeTitle' => false]
            ) ?>
        <?php elseif ($action === 'registerMember'): ?>
            <?= $this->Html->link(
                '<i class="fas fa-home"></i> ' . __('Home'),
                ['controller' => 'Books', 'action' => 'search'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fas fa-user-plus"></i> ' . __('Register'),
                ['class' => 'right', 'escapeTitle' => false]
            ) ?>
        <?php else: ?>
            <?= $this->Html->link(
                '<i class="fas fa-home"></i> ' . __('Home'),
                [
                    'controller' => 'Books',
                    'action' => 'search',
                ],
                [
                    'class' => 'button right',
                    'escapeTitle' => false,
                ]
            ) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
