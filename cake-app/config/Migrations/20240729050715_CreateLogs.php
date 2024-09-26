<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateLogs extends AbstractMigration
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
        $table = $this->table('logs', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'URL',
        ]);
        $table->addColumn('ip_address', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => 'IP Address',
        ]);
        $table->addColumn('user_id', 'biginteger', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'comment' => 'User ID',
        ]);
        $table->addColumn('timestamp', 'timestamp', [
            'default' => null,
            'null' => false,
            'comment' => 'Timestamp',
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
        $this->table('logs')->drop()->save();
    }
}
