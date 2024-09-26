<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 * @var array $authUser
 */

use App\Model\Entity\User;

?>
<?= $this->element('sidebar') ?>
<div class="books index large-9 medium-8 columns content">
    <div class="row">
        <div class="columns small-6">
            <h3><?= __('Books') ?></h3>
        </div>
        <div class="columns small-6 text-right">
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle"></i> ' . __('Publish New Book'),
                ['controller' => 'Books', 'action' => 'add'],
                ['class' => 'button', 'escape' => false]
            ) ?>
        </div>
    </div>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem;">
        <?php foreach ($books as $book):
            $coverImage = $this->Book->getCoverImage($book);
            ?>
            <div class="card small-12 medium-8 large-4 columns" style="
                margin-bottom: 1rem;
            ">
                <div class="card-section">
                    <div style="text-align: center;">
                        <?= $this->Html->link(
                            $this->Html->image($coverImage['url'],
                                [
                                    'alt' => $coverImage['alt'],
                                    'style' => 'width:160px; height:250px; object-fit:cover; border-radius: 5px;',
                                ]
                            ),
                            ['action' => 'view', $book->id],
                            ['escape' => false]
                        ) ?>
                    </div>
                    <h4><?= h($book->title) ?></h4>
                    <?php if (!$book->status): ?>
                        <p style="color: red; font-size: 0.9em;"><?= __('Disabled for public') ?></p>
                    <?php else: ?>
                        <p style="color: green; font-size: 0.9em;"><?= __('Visible for public') ?></p>
                    <?php endif; ?>
                    <p><strong><?= __('Author:') ?></strong> <?= h($book->author) ?></p>
                    <p><strong><?= __('Publisher:') ?></strong>
                    <?php
                    if ($book->hasValue('user')) {
                        if (!User::isPublisher($authUser['role'])) {
                            echo $this->Html->link($book->user->name, ['controller' => 'Users', 'action' => 'view', $book->user->id]);
                        } else {
                            echo h($book->user->name);
                        }
                    }
                    ?>
                </div>
                <div class="card-section row">
                    <a href="<?= $this->Url->build(['action' => 'view', $book->id]) ?>" class="button" style="display: block; width: 100%; margin-bottom: 2px;">
                        <i class="fas fa-eye"></i> <?= __('View') ?>
                    </a>
                    <a href="<?= $this->Url->build(['action' => 'edit', $book->id]) ?>" class="button" style="display: block; width: 100%; margin-bottom: 2px;">
                        <i class="fas fa-edit"></i> <?= __('Edit') ?>
                    </a>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash"></i> ' . __('Delete'),
                        ['action' => 'delete', $book->id],
                        [
                            'confirm' => __('Are you sure you want to delete "{0}"?', $book->title),
                            'class' => 'button alert',
                            'style' => 'display: block; width: 100%; margin-bottom: 2px;',
                            'escapeTitle' => false,
                        ]
                    ) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?= $this->element('paginator') ?>
</div>
