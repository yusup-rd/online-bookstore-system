<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 * @var array $publisherOptions
 * @var array $user
 * @var array $categories
 */

use App\Model\Entity\Book;

?>
<?= $this->element('sidebar') ?>
<div class="books form large-9 medium-8 columns content">
    <?= $this->Form->create($book, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Add Book') ?></legend>
        <?php
            echo $this->Book->renderPublisherSelect($user, $publisherOptions);
            echo $this->Form->control('title');
            echo $this->Form->control('isbn', ['label' => 'ISBN']);
            echo $this->Form->control('author');
            echo $this->Form->control('synopsis');
            echo $this->Form->control('coverpage', ['type' => 'file', 'label' => 'Cover Page']);
            echo $this->Form->control('url', ['label' => 'URL']);
            echo $this->Form->control('status', [
                'type' => 'select',
                'options' => Book::BOOK_STATUSES,
            ]);
            echo $this->Form->control('categories._ids', ['options' => $categories, 'multiple' => 'checkbox']);

        ?>
    </fieldset>
    <?= $this->element('footer_buttons') ?>
    <?= $this->Form->end() ?>
</div>
