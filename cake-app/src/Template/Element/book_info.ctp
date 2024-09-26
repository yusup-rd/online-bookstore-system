<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */

$coverImage = $this->Book->getCoverImage($book);
?>

<div style="display: flex; justify-content: space-between;">
    <div style="flex: 1;">
        <h3><?= h($book->title) ?></h3>
        <p><strong>Author:</strong> <?= h($book->author) ?></p>
        <p><strong>ISBN:</strong> <?= h($book->isbn) ?></p>
        <p><strong>Synopsis:</strong> <?= h($book->synopsis) ?></p>
    </div>
    <div style="flex: 1; text-align: right;">
        <div>
            <?= $this->Html->image($coverImage['url'],
                [
                    'alt' => $coverImage['alt'],
                    'style' => 'max-width: 200px; max-height: 100%;',
                ]
            ) ?>
        </div>
    </div>
</div>
