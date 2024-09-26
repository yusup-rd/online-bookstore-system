<?php

namespace App\Seeds;

use Cake\I18n\Time;
use Migrations\AbstractSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
                'name' => 'Science Fiction',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Fantasy',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Mystery',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Romance',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Thriller',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Historical Fiction',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Biography',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Non-Fiction',
                'status' => 1,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Self-Help',
                'status' => 0,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'name' => 'Horror',
                'status' => 0,
                'deleted' => null,
                'created' => $now,
                'modified' => $now,
            ],
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
