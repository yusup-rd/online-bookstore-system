<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 * @var \App\Model\Entity\Book $book
 * @var \App\Model\Entity\User[] $users
 * @var \App\Model\Entity\Book[] $books
 */
?>

<style>
    .rating .fa-star {
        font-size: 1.5em;
        color: #ffc107;
        cursor: pointer;
    }

    .rating .fa-star.far {
        color: #e4e5e9;
    }

    textarea {
        resize: none;
    }
</style>

<?= $this->element('sidebar') ?>
<div class="reviews form large-9 medium-8 columns content">
    <?= $this->element('book_info', ['book' => $book]) ?>

    <?= $this->Form->create($review) ?>
    <fieldset>
        <legend><?= __('Edit Review') ?></legend>
        <div class="rating" style="margin-bottom: 10px;">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fa fa-star <?= $i <= $review->rating ? 'fas' : 'far' ?>" data-value="<?= $i ?>"></i>
            <?php endfor; ?>
        </div>
        <?= $this->Form->control('comment', ['type' => 'textarea']) ?>
        <?= $this->Form->hidden('rating', ['id' => 'rating-input', 'value' => $review->rating]) ?>
        <?= $this->Form->hidden('book_id', ['value' => $review->book_id]) ?>
        <?= $this->Form->hidden('user_id', ['value' => $review->user_id]) ?>
        <?= $this->element('footer_buttons') ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating .fa-star');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;

                stars.forEach(s => {
                    s.classList.remove('fas');
                    s.classList.add('far');
                });

                for (let i = 0; i < rating; i++) {
                    stars[i].classList.remove('far');
                    stars[i].classList.add('fas');
                }
            });
        });
    });
</script>
