<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>

<?= $this->element('sidebar') ?>
<div class="reviews view large-9 medium-8 columns content">
    <div style="display: flex; justify-content: space-between;">
        <div>
            <h3><?= h($review->book->title) ?></h3>
            <p><strong>Author:</strong> <?= h($review->book->author) ?></p>
            <p><strong>Reviewer:</strong>
                <?= $this->Review->linkToReviewer($review->user) ?>
            </p>
            <p><strong>Rating:</strong> <?= $this->Number->format($review->rating) ?></p>
            <p>
                <?= $this->Review->linkToBook($review->book, 'See the book') ?>
            </p>
        </div>

        <div>
            <?php
            $coverImage = $this->Book->getCoverImage($review->book);
            ?>
            <div>
                <?= $this->Html->link(
                    $this->Html->image($coverImage['url'], [
                        'alt' => $coverImage['alt'],
                        'style' => 'max-width: 200px; max-height: 100%;',
                    ]),
                    ['controller' => 'Books', 'action' => 'view', $review->book->id],
                    ['escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <div>
        <h4>Comment</h4>
        <p><?= h($review->comment) ?></p>
    </div>
    <?= $this->element('footer_buttons') ?>
</div>
