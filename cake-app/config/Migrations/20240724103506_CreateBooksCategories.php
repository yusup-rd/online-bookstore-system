<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateBooksCategories extends AbstractMigration
{
    /**
     * Up method.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('books_categories', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('book_id', 'biginteger', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'Related book ID to category',
            'signed' => false,
        ]);
        $table->addColumn('category_id', 'biginteger', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'Related category ID to book',
            'signed' => false,
        ]);
        $table->create();
    }

    /**
     * Down Method.
     *
     * @return void
     */
    public function down()
    {
        $this->table('books_categories')->drop()->save();
    }
}
