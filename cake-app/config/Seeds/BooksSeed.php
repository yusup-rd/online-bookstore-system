<?php

namespace App\Seeds;

use Cake\I18n\Time;
use Migrations\AbstractSeed;

/**
 * Books seed.
 */
class BooksSeed extends AbstractSeed
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
                'user_id' => 3,
                'title' => 'The Great Gatsby',
                'isbn' => '9780743273565',
                'author' => 'F. Scott Fitzgerald',
                'synopsis' => 'A novel set in the Roaring Twenties.',
                'coverpage' => 'cover_gatsby.jpg',
                'url' => 'https://example.com/gatsby',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 4,
                'title' => 'To Kill a Mockingbird',
                'isbn' => '9780061120084',
                'author' => 'Harper Lee',
                'synopsis' => 'A novel about racial injustice in the Deep South.',
                'coverpage' => 'cover_mockingbird.jpg',
                'url' => 'https://example.com/mockingbird',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 5,
                'title' => '1984',
                'isbn' => '9780451524935',
                'author' => 'George Orwell',
                'synopsis' => 'A dystopian novel about totalitarianism.',
                'coverpage' => 'cover_1984.jpg',
                'url' => 'https://example.com/1984',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 6,
                'title' => 'Pride and Prejudice',
                'isbn' => '9781503290563',
                'author' => 'Jane Austen',
                'synopsis' => 'A romantic novel of manners.',
                'coverpage' => 'cover_pride.jpg',
                'url' => 'https://example.com/pride',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 7,
                'title' => 'Moby Dick',
                'isbn' => '9781503280786',
                'author' => 'Herman Melville',
                'synopsis' => 'A novel about the voyage of the whaling ship Pequod.',
                'coverpage' => 'cover_mobydick.jpg',
                'url' => 'https://example.com/mobydick',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 3,
                'title' => 'War and Peace',
                'isbn' => '9781400079988',
                'author' => 'Leo Tolstoy',
                'synopsis' => 'A historical novel set during the Napoleonic Wars.',
                'coverpage' => 'cover_warpeace.jpg',
                'url' => 'https://example.com/warpeace',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 4,
                'title' => 'The Catcher in the Rye',
                'isbn' => '9780316769488',
                'author' => 'J.D. Salinger',
                'synopsis' => 'A novel about teenage rebellion and angst.',
                'coverpage' => 'cover_catcher.jpg',
                'url' => 'https://example.com/catcher',
                'status' => 0,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 5,
                'title' => 'The Hobbit',
                'isbn' => '9780547928227',
                'author' => 'J.R.R. Tolkien',
                'synopsis' => 'A fantasy novel about the journey of Bilbo Baggins.',
                'coverpage' => 'cover_hobbit.jpg',
                'url' => 'https://example.com/hobbit',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 6,
                'title' => 'The Odyssey',
                'isbn' => '9780140268867',
                'author' => 'Homer',
                'synopsis' => 'An epic poem about the adventures of Odysseus.',
                'coverpage' => 'cover_odyssey.jpg',
                'url' => 'https://example.com/odyssey',
                'status' => 0,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_id' => 7,
                'title' => 'The Divine Comedy',
                'isbn' => '9780140448955',
                'author' => 'Dante Alighieri',
                'synopsis' => 'An epic poem describing the journey through Hell, Purgatory, and Paradise.',
                'coverpage' => 'cover_divinecomedy.jpg',
                'url' => 'https://example.com/divinecomedy',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
        ];

        $table = $this->table('books');
        $table->insert($data)->save();
    }
}
