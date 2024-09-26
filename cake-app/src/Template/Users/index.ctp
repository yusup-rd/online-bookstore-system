<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var array $sessionUser
 */

use App\Model\Entity\User;

$sessionUserId = $sessionUser['id'];
$sessionUserRole = $sessionUser['role'];

?>
<?= $this->element('sidebar') ?>
<div class="users index large-9 medium-8 columns content">
    <div class="row">
        <div class="columns small-6">
            <h3><?= __('Users') ?></h3>
        </div>
        <?php if (User::isAdmin($sessionUserRole) || User::isAssistant($sessionUserRole)): ?>
            <div class="columns small-6 text-right">
                <?= $this->Html->link(
                    '<i class="fas fa-user-plus"></i> ' . __('Register New User'),
                    ['action' => 'add'],
                    ['class' => 'button', 'escape' => false]
                ) ?>
            </div>
        <?php endif; ?>
    </div>
    <table>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= __(User::USER_STATUSES[$user->status]) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?php if (
                        $user->status &&
                        !User::isPublisher($sessionUserRole) &&
                        User::isPublisher($user->role)
                    ): ?>
                        <?= $this->Html->link(__('Email'), ['action' => 'mail', $user->id]) ?>
                    <?php endif; ?>
                    <?php if (
                        $user->id !== $sessionUserId &&
                        (
                            User::isAdmin($sessionUserRole) ||
                            (User::isAssistant($sessionUserRole) && User::isPublisher($user->role))
                        )
                    ): ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $user->id],
                            ['confirm' => __('Are you sure you want to delete {0}?', $user->name)]
                        ) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('paginator') ?>
</div>
