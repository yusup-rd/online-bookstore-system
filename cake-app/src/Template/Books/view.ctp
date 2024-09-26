<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 * @var array $sessionUser
 * @var float|null $averageRating
 */
?>

<?= $this->element('sidebar') ?>
<div class="<?= $this->Book->getSearchClass($sessionUser) ?>">
    <h3><?= h($book->title) ?></h3>
    <div class="row">
        <div class="medium-6 columns">
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Publisher') ?></th>
                    <td>
                        <?= $this->Book->displayUserName($book, $sessionUser) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Title') ?></th>
                    <td><?= h($book->title) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('ISBN') ?></th>
                    <td><?= h($book->isbn) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Author') ?></th>
                    <td><?= h($book->author) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Category') ?></th>
                    <td><?= $this->Book->getCategoryList($book) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('URL') ?></th>
                    <td><?= h($book->url) ?></td>
                </tr>
                <?php if ($sessionUser): ?>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $book->display_status ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="medium-6 columns">
            <?php
            $coverImage = $this->Book->getCoverImage($book);
            ?>
            <div class="text-center">
                <?= $this->Html->image($coverImage['url'],
                    [
                        'alt' => $coverImage['alt'],
                        'style' => 'max-width: 200px; max-height: 100%;',
                    ]
                ) ?>
            </div>
        </div>
    </div>
    <div>
        <?php if (!empty($book->synopsis)): ?>
            <div class="row">
                <h4><?= __('Synopsis') ?></h4>
                <?= $this->Text->autoParagraph(h($book->synopsis)) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <?= $this->element('footer_buttons') ?>
    </div>

    <div class="row">
        <?= $this->element('reviews', ['reviews' => $book->reviews, 'averageRating' => $averageRating]) ?>
    </div>
</div>
