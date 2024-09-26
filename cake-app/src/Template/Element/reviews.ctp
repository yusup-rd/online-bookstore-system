<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review[] $reviews
 * @var \App\Model\Entity\User $authUser
 * @var float|null $averageRating
 */
?>

<style>
    .related-reviews {
        margin: 20px 0;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reviews-list {
        list-style: none;
        padding: 0;
    }

    .review-item {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .review-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .review-rating {
        display: flex;
        align-items: center;
    }

    .review-rating .fa-star {
        color: #ffc107;
        font-size: 1.2em;
        margin-right: 2px;
    }

    .review-date {
        font-size: 0.9em;
        color: #666;
    }

    .review-user {
        font-weight: bold;
        color: #ad1022;
    }

    .review-actions {
        display: flex;
        gap: 10px;
    }

    .review-actions i {
        cursor: pointer;
        color: #ad1022;
    }

    .review-comment {
        font-size: 1em;
        color: #333;
        margin-top: 10px;
    }

    .average-rating {
        float: right;
        color: #ffc107;
    }

    .average-rating span {
        margin-left: 5px;
        font-size: 1em;
        color: #333;
    }
</style>

<div class="related-reviews">
    <h3>
        <?= __('Reviews') ?>
        <?php if ($averageRating): ?>
            <span class="average-rating">
                <i class="fas fa-star"></i>
                <span><?= $this->Number->format($averageRating, ['places' => 1]) ?></span>
            </span>
        <?php else: ?>
            <span><?= __('No ratings yet') ?></span>
        <?php endif; ?>
    </h3>
    <?php if (!empty($reviews)): ?>
        <ul class="reviews-list">
            <?php foreach ($reviews as $review): ?>
                <li class="review-item">
                    <div class="review-header">
                        <div class="review-rating">
                            <?= str_repeat('<i class="fas fa-star"></i>', $review->rating) ?>
                            <?= str_repeat('<i class="far fa-star"></i>', 5 - $review->rating) ?>
                        </div>
                        <em class="review-date"><?= h($review->created) ?></em>
                    </div>

                    <div class="review-info">
                        <strong class="review-user"><?= h($review->user->name) ?></strong>
                        <?php if ($authUser !== null && $authUser['id'] === $review->user_id): ?>
                            <div class="review-actions">
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit" title="Edit"></i>',
                                    ['controller' => 'Reviews', 'action' => 'edit', $review->id],
                                    ['escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash" title="Delete"></i>',
                                    ['controller' => 'Reviews', 'action' => 'delete', $review->id],
                                    ['confirm' => __('Are you sure you want to delete this review?'), 'escape' => false]
                                ) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="review-comment"><?= h($review->comment) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><?= __('No reviews found.') ?></p>
    <?php endif; ?>
</div>
