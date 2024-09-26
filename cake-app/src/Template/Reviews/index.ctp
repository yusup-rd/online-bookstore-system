<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review[]|\Cake\Collection\CollectionInterface $reviews
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\User;

?>

<style>
    .comment {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<?= $this->element('sidebar') ?>
<div class="reviews index large-9 medium-8 columns content">
    <h3><?= __('Reviews') ?></h3>
    <table>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id', ['label' => 'Reviewer']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('book_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rating') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', ['label' => 'Added']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified', ['label' => 'Edited']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
            <tr>
                <td>
                    <?= $this->Review->linkToReviewer($review->user) ?>
                </td>
                <td>
                    <?= $this->Review->linkToBook($review->book) ?>
                </td>
                <td><?= $this->Number->format($review->rating) ?></td>
                <td>
                    <div class="comment"><?= h($review->comment) ?></div>
                </td>
                <td><?= h($review->created) ?></td>
                <td><?= h($review->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $review->id]) ?>
                    <?php if (User::isMember($user['role'])): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $review->id]) ?>
                    <?php endif; ?>
                    <?php if (User::isAdmin($user['role']) || User::isAssistant($user['role'])): ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            [
                                'action' => 'delete',
                                $review->id,
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete this review?'),
                            ]
                        ) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('paginator') ?>
</div>
