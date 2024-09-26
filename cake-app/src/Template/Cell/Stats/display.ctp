<?php
/**
 * @var \App\Model\Entity\Book|null $topBook
 * @var int|null $topBookId
 * @var \App\Model\Entity\User|null $publisher
 * @var int $totalBooks
 * @var int $publishersCount
 */
?>
<style>
    .statistics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, auto);
        gap: 20px;
        max-width: 1200px;
        min-height: 360px;
        margin: 0 auto 30px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .grid-item {
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .grid-item h4 {
        margin-bottom: 10px;
        font-size: 1.5em;
    }

    .grid-item p {
        font-size: 1.2em;
        color: #666;
    }

    .grid-item span {
        font-weight: bold;
        color: #ad1022;
    }
</style>
<div class="statistics-grid">
    <div class="grid-item top-book">
        <h4><?= __('Top Book') ?></h4>
        <p>
            <?php if ($topBook && $topBookId): ?>
                <span>
                    <?= $this->Html->link(h($topBook->title), ['controller' => 'Books', 'action' => 'view', $topBookId]) ?>
                </span>
            <?php else: ?>
                <span>No top book found.</span>
            <?php endif; ?>
        </p>
    </div>

    <div class="grid-item top-publisher">
        <h4><?= __('Top Publisher') ?></h4>
        <p>
            <span>
                <?php if ($publisher): ?>
                    <?= h($publisher->name) ?>
                <?php else: ?>
                    <span>No top publisher found.</span>
                <?php endif; ?>
            </span>
        </p>
    </div>

    <div class="grid-item total-books">
        <h4><?= __('Total Books') ?></h4>
        <p>
            <span>
                <?= $totalBooks ?>
            </span>
        </p>
    </div>

    <div class="grid-item total-publishers">
        <h4><?= __('Total Publishers') ?></h4>
        <p>
            <span>
                <?= $publishersCount ?>
            </span>
        </p>
    </div>
</div>
