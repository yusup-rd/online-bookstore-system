<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

use App\Model\Entity\Category;

?>
<?= $this->element('sidebar') ?>
<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Add Category') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('status', ['options' => Category::CATEGORY_STATUSES]);
        ?>
    </fieldset>
    <?= $this->element('footer_buttons') ?>
    <?= $this->Form->end() ?>
</div>
