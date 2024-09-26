<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

use App\Model\Entity\Category;
use App\Model\Entity\Book;

?>
<?= $this->element('sidebar') ?>
<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= __(Category::CATEGORY_STATUSES[$category->status]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ID') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($category->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($category->modified) ?></td>
        </tr>
    </table>
    <?= $this->element('footer_buttons') ?>
    <div class="related">
        <?php if (!empty($category->books)): ?>
        <h4><?= __('Related Books') ?></h4>
        <table>
            <tr>
                <th scope="col"><?= __('Book ID') ?></th>
                <th scope="col"><?= __('Publisher') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('ISBN') ?></th>
                <th scope="col"><?= __('Author') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->books as $books): ?>
            <tr>
                <td><?= h($books->id) ?></td>
                <td>
                    <?= $this->Html->link(
                        h($books->user->name),
                        ['controller' => 'Users', 'action' => 'view', $books->user->id]
                    ) ?>
                </td>
                <td><?= h($books->title) ?></td>
                <td><?= h($books->isbn) ?></td>
                <td><?= h($books->author) ?></td>
                <td><?= __(Book::BOOK_STATUSES[$books->status]) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Books', 'action' => 'view', $books->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Books', 'action' => 'edit', $books->id]) ?>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        [
                            'controller' => 'Books',
                            'action' => 'delete',
                            $books->id,
                        ],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $books->id),
                        ]
                    ) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
