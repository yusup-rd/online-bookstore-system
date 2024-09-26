<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateSummaries extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('summaries', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('search_id', 'biginteger', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'ID of searched book',
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => 'Created date',
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
        $this->table('summaries')->drop()->save();
    }
}
