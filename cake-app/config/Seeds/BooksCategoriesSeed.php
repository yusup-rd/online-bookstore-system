<?php

namespace App\Seeds;

use Migrations\AbstractSeed;

/**
 * BooksCategories seed.
 */
class BooksCategoriesSeed extends AbstractSeed
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
        $data = [
            [
                'book_id' => 1, // The Great Gatsby
                'category_id' => 6, // Historical Fiction
            ],
            [
                'book_id' => 1, // The Great Gatsby
                'category_id' => 3, // Mystery
            ],
            [
                'book_id' => 2, // To Kill a Mockingbird
                'category_id' => 3, // Mystery
            ],
            [
                'book_id' => 2, // To Kill a Mockingbird
                'category_id' => 8, // Non-Fiction
            ],
            [
                'book_id' => 3, // 1984
                'category_id' => 1, // Science Fiction
            ],
            [
                'book_id' => 4, // Pride and Prejudice
                'category_id' => 4, // Romance
            ],
            [
                'book_id' => 5, // Moby Dick
                'category_id' => 8, // Non-Fiction
            ],
            // Skip War and Peace
            // Skip The Catcher in the Rye
            [
                'book_id' => 8, // The Hobbit
                'category_id' => 2, // Fantasy
            ],
            // Skip The Odyssey
            // Skip The Divine Comedy
        ];

        $table = $this->table('books_categories');
        $table->insert($data)->save();
    }
}
