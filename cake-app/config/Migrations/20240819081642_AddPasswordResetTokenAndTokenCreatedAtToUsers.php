<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class AddPasswordResetTokenAndTokenCreatedAtToUsers extends AbstractMigration
{
    /**
     * Up method to apply the migration changes.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('users');
        $table->addColumn('password_reset_token', 'string', [
            'null' => true,
            'default' => null,
            'limit' => 255,
            'comment' => 'Token data',
            'after' => 'status',
        ]);
        $table->addColumn('token_expired_at', 'datetime', [
            'null' => true,
            'default' => null,
            'comment' => 'Token expiration date',
            'after' => 'password_reset_token',
        ]);
        $table->update();
    }

    /**
     * Down method to revert the migration changes.
     *
     * @return void
     */
    public function down()
    {
        $table = $this->table('users');
        $table->removeColumn('password_reset_token');
        $table->removeColumn('token_expired_at');
        $table->update();
    }
}
