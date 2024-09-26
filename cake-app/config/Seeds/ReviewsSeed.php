<?php

namespace App\Seeds;

use Cake\I18n\Time;
use Migrations\AbstractSeed;

/**
 * ReviewsSeed seed.
 */
class ReviewsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $now = Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss');

        $data = [
            [
                'user_id' => 8, // memberuser1
                'book_id' => 1,
                'rating' => 5,
                'comment' => 'An excellent read!',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 9, // memberuser2
                'book_id' => 2,
                'rating' => 4,
                'comment' => 'Very informative.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 10, // memberuser3
                'book_id' => 3,
                'rating' => 3,
                'comment' => 'Good, but could be better.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 8, // memberuser1
                'book_id' => 4,
                'rating' => 5,
                'comment' => 'A masterpiece!',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 9, // memberuser2
                'book_id' => 5,
                'rating' => 4,
                'comment' => 'Very engaging.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 10, // memberuser3
                'book_id' => 6,
                'rating' => 3,
                'comment' => 'Interesting, but not my favorite.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 8, // memberuser1
                'book_id' => 7,
                'rating' => 5,
                'comment' => 'Highly recommended!',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 9, // memberuser2
                'book_id' => 8,
                'rating' => 4,
                'comment' => 'A good read.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 10, // memberuser3
                'book_id' => 9,
                'rating' => 3,
                'comment' => 'Not bad, but could be better.',
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
        ];

        $table = $this->table('reviews');
        $table->insert($data)->save();
    }
}
