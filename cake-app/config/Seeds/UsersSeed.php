<?php

namespace App\Seeds;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Migrations\AbstractSeed;

/**
 * UsersSeed seed.
 */
class UsersSeed extends AbstractSeed
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
        $encryptedPassword = (new DefaultPasswordHasher())->hash('@1234Qwe');

        $data = [
            // Admin user
            [
                'login' => 'admin',
                'password' => $encryptedPassword,
                'role' => 'admin',
                'name' => 'Administrator',
                'address' => '123 Admin Street',
                'phone' => '1234567890',
                'fax' => '0987654321',
                'email' => 'admin@example.com',
                'url' => 'http://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            // Assistant user
            [
                'login' => 'assistant',
                'password' => $encryptedPassword,
                'role' => 'assistant',
                'name' => 'Assistant User',
                'address' => '456 Assistant Road',
                'phone' => '1234567891',
                'fax' => '0987654322',
                'email' => 'assistant@example.com',
                'url' => 'http://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            // Publisher users
            [
                'login' => 'publisher1',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher One',
                'address' => '789 Publisher Lane',
                'phone' => '1234567892',
                'fax' => '0987654323',
                'email' => 'publisher1@example.com',
                'url' => 'http://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'publisher2',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher Two',
                'address' => '789 Publisher Lane',
                'phone' => '1234567893',
                'fax' => '0987654324',
                'email' => 'publisher2@example.com',
                'url' => 'http://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'publisher3',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher Three',
                'address' => '789 Publisher Lane',
                'phone' => '1234567894',
                'fax' => '0987654325',
                'email' => 'publisher3@example.com',
                'url' => 'http://example.com',
                'status' => 0,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'publisher4',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher Four',
                'address' => '789 Publisher Lane',
                'phone' => '1234567895',
                'fax' => '0987654326',
                'email' => 'publisher4@example.com',
                'url' => 'http://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'publisher5',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher Five',
                'address' => '789 Publisher Lane',
                'phone' => '1234567896',
                'fax' => '0987654327',
                'email' => 'publisher5@example.com',
                'url' => 'http://example.com',
                'status' => 0,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            // Member users
            [
                'login' => 'memberuser1',
                'password' => $encryptedPassword,
                'role' => 'member',
                'name' => 'Member User 1',
                'address' => '111 Memeber St',
                'phone' => '3456789012',
                'fax' => '3456789012',
                'email' => 'member1@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'memberuser2',
                'password' => $encryptedPassword,
                'role' => 'member',
                'name' => 'Member User 2',
                'address' => '222 Member Ave',
                'phone' => '4567890123',
                'fax' => '4567890123',
                'email' => 'member2@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'login' => 'memberuser3',
                'password' => $encryptedPassword,
                'role' => 'member',
                'name' => 'Member User 3',
                'address' => '333 Member Blvd',
                'phone' => '5678901234',
                'fax' => '5678901234',
                'email' => 'member3@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'created' => $now,
                'modified' => $now,
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
