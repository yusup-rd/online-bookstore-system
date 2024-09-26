<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateReviews extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('reviews', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('user_id', 'biginteger', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Member user id',
        ]);
        $table->addColumn('book_id', 'biginteger', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Book id',
        ]);
        $table->addColumn('rating', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => false,
            'comment' => 'Rating',
        ]);
        $table->addColumn('comment', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => 'Review comment',
        ]);
        $table->addColumn('deleted', 'datetime', [
            'default' => null,
            'null' => true,
            'comment' => 'Deleted date',
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => 'Created date',
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => 'Modified date',
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
        $this->table('reviews')->drop()->save();
    }
}
