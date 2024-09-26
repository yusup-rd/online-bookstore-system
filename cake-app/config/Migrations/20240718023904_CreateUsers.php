<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'biginteger', [
            'autoIncrement' => true,
            'comment' => 'ID',
            'default' => null,
            'limit' => null,
            'null' => false,
            'signed' => false,
        ]);
        $table->addColumn('login', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Login',
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Password',
        ]);
        $table->addColumn('role', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => false,
            'comment' => 'Role',
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Name',
        ]);
        $table->addColumn('address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => 'Address',
        ]);
        $table->addColumn('phone', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
            'comment' => 'Phone',
        ]);
        $table->addColumn('fax', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
            'comment' => 'Fax',
        ]);
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Email',
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
            'comment' => 'Status of the user (1:active/0:inactive)',
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
        $this->table('users')->drop()->save();
    }
}
