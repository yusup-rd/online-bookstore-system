<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateBooks extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('books', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'Related publisher',
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Title',
        ]);
        $table->addColumn('isbn', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => 'ISBN Code',
        ]);
        $table->addColumn('author', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('synopsis', 'text', [
            'default' => null,
            'null' => true,
            'comment' => 'Book brief summary',
        ]);
        $table->addColumn('coverpage', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => 'Book cover page',
        ]);
        $table->addColumn('url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => 'URL',
        ]);
        $table->addColumn('status', 'boolean', [
            'default' => true,
            'null' => false,
            'comment' => 'Status of the book (1:active/0:inactive)',
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
        $this->table('books')->drop()->save();
    }
}
