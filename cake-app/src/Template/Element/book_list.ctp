<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[] $books
 * @var string $noBooksMessage
 */
?>

<div class="books-row">
    <?php if (!empty($books)): ?>
        <?php foreach ($books as $index => $book): ?>
            <?php $coverImage = $this->Book->getCoverImage($book); ?>
            <div class="book-card">
                <div class="book-number">
                    <i class="fas fa-medal"></i> <?= $index + 1 ?>
                </div>
                <?= $this->Html->link(
                    $this->Html->image($coverImage['url'], [
                        'alt' => $coverImage['alt'],
                        'style' => 'width:160px; height:250px; object-fit:cover; border-radius: 5px;',
                    ]),
                    ['action' => 'view', $book->id],
                    ['escape' => false]
                ) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?= h($noBooksMessage) ?></p>
    <?php endif; ?>
</div>
