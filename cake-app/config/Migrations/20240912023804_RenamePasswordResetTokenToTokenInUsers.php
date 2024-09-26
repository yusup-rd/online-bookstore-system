<?php

namespace App\Migrations;

use Migrations\AbstractMigration;

class RenamePasswordResetTokenToTokenInUsers extends AbstractMigration
{
    /**
     * Up method to apply the migration changes.
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('users');
        $table->renameColumn('password_reset_token', 'token');
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
        $table->renameColumn('token', 'password_reset_token');
        $table->update();
    }
}
