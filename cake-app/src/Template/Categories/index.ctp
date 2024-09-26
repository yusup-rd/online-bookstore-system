<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */

use App\Model\Entity\Category;

?>
<?= $this->element('sidebar') ?>
<div class="categories index large-9 medium-8 columns content">
    <div class="row">
        <div class="columns small-6">
            <h3><?= __('Categories') ?></h3>
        </div>
        <div class="columns small-6 text-right">
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle"></i> ' . __('Add New Category'),
                ['action' => 'add'],
                ['class' => 'button', 'escapeTitle' => false]
            ) ?>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $this->Number->format($category->id) ?></td>
                <td><?= h($category->name) ?></td>
                <td><?= __(Category::CATEGORY_STATUSES[$category->status]) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        [
                            'action' => 'delete',
                            $category->id,
                        ],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $category->id),
                        ]
                    ) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('paginator') ?>
</div>
