<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateCategories extends AbstractMigration
{
    /**
     * Up method.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('categories', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Name of the category',
        ]);
        $table->addColumn('status', 'boolean', [
            'default' => true,
            'null' => false,
            'comment' => 'Status of the category (1: Enabled / 2: Disabled)',
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
        $this->table('categories')->drop()->save();
    }
}
