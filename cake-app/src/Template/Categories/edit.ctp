<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

use App\Model\Entity\Category;

$bookCount = count($category->books);

?>
<?= $this->element('sidebar') ?>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Edit Category') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('status', ['options' => Category::CATEGORY_STATUSES]);
        ?>
    </fieldset>
    <div style="margin-bottom: 25px;">
        <p><?= __('Related Books') ?>: <?= $bookCount ?></p>
        <?php if ($bookCount > 0): ?>
            <?= $this->Html->link(
                __('View related books'),
                [
                    'controller' => 'Categories',
                    'action' => 'view',
                    $category->id,
                ]
            ) ?>
        <?php endif; ?>
    </div>
    <?= $this->element('footer_buttons') ?>
    <?= $this->Form->end() ?>
</div>
