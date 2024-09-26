<?php
/**
 * @var \App\Model\Entity\Book[] $trendingBooks
 * @var \App\Model\Entity\Book[] $latestBooks
 * @var \App\Model\Entity\Book[] $topRatedBooks
 */
?>

<style>
    .trends-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px 10px;
        min-height: 360px;
    }

    .btn-group {
        margin-bottom: 25px;
        display: flex;
        width: 400px;
        background-color: #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
    }

    .btn {
        flex: 1;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn.active {
        background-color: #ad1022;
        color: white;
    }

    .books-row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .book-card {
        flex: 0 0 auto;
        margin-right: 10px;
        position: relative;
    }

    .book-number {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

<div class="trends-cell">
    <div class="btn-group">
        <div id="trending-btn" class="btn active" onclick="showBooks('trending')">
            <i class="fas fa-fire"></i> Trending
        </div>
        <div id="latest-btn" class="btn" onclick="showBooks('latest')">
            <i class="fas fa-clock"></i> New Arrivals
        </div>
        <div id="top-rated-btn" class="btn" onclick="showBooks('topRated')">
            <i class="fas fa-star"></i> Top Rated
        </div>
    </div>

    <div id="trending-books" class="books-row">
        <?= $this->element('book_list', [
            'books' => $trendingBooks,
            'noBooksMessage' => __('No trending books available.'),
        ]) ?>
    </div>

    <div id="latest-books" class="books-row" style="display: none;">
        <?= $this->element('book_list', [
            'books' => $latestBooks,
            'noBooksMessage' => __('No latest books available.'),
        ]) ?>
    </div>

    <div id="top-rated-books" class="books-row" style="display: none;">
        <?= $this->element('book_list', [
            'books' => $topRatedBooks,
            'noBooksMessage' => __('No top-rated books available.'),
        ]) ?>
    </div>
</div>

<script>
    function showBooks(type) {
        const latestBooks = document.getElementById('latest-books');
        const trendingBooks = document.getElementById('trending-books');
        const topRatedBooks = document.getElementById('top-rated-books');
        const latestBtn = document.getElementById('latest-btn');
        const trendingBtn = document.getElementById('trending-btn');
        const topRatedBtn = document.getElementById('top-rated-btn');

        latestBooks.style.display = 'none';
        trendingBooks.style.display = 'none';
        topRatedBooks.style.display = 'none';
        latestBtn.classList.remove('active');
        trendingBtn.classList.remove('active');
        topRatedBtn.classList.remove('active');

        if (type === 'latest') {
            latestBooks.style.display = 'flex';
            latestBtn.classList.add('active');
        } else if (type === 'trending') {
            trendingBooks.style.display = 'flex';
            trendingBtn.classList.add('active');
        } else if (type === 'topRated') {
            topRatedBooks.style.display = 'flex';
            topRatedBtn.classList.add('active');
        }
    }
</script>
