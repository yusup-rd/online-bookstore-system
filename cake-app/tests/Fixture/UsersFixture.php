<?php
namespace App\Test\Fixture;

use App\Model\Entity\User;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'users'];

    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $encryptedPassword = (new DefaultPasswordHasher())->hash('@1234Qwe');
        $this->records = [
            [
                'id' => 1,
                'login' => 'adminuser',
                'password' => $encryptedPassword,
                'role' => 'admin',
                'name' => 'Admin User',
                'address' => '123 Admin St',
                'phone' => '0123456789',
                'fax' => '0123456789',
                'email' => 'admin@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 2,
                'login' => 'assistantuser',
                'password' => $encryptedPassword,
                'role' => 'assistant',
                'name' => 'Assistant User',
                'address' => '456 Assistant Ave',
                'phone' => '0987654321',
                'fax' => '0987654321',
                'email' => 'assistant@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 3,
                'login' => 'publisheruser1',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher User 1',
                'address' => '789 Publisher St',
                'phone' => '1234567890',
                'fax' => '1234567890',
                'email' => 'publisher1@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => null,
                'token_expired_at' => null,
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 4,
                'login' => 'publisheruser2',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher User 2',
                'address' => '101 Publisher Blvd',
                'phone' => '2345678901',
                'fax' => '2345678901',
                'email' => 'publisher2@example.com',
                'url' => 'https://example.com',
                'status' => 0,
                'token' => null,
                'token_expired_at' => null,
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 5,
                'login' => 'publisheruser3',
                'password' => $encryptedPassword,
                'role' => 'publisher',
                'name' => 'Publisher User 3',
                'address' => '101 Publisher Blvd',
                'phone' => '2345678901',
                'fax' => '2345678901',
                'email' => 'publisher3@example.com',
                'url' => 'https://example.com',
                'status' => 1,
                'token' => 'valid_token_123',
                'token_expired_at' => null,
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 6,
                'login' => 'memberuser1',
                'password' => $encryptedPassword,
                'role' => 'member',
                'name' => 'Member User',
                'address' => '202 Member St',
                'phone' => '3456789012',
                'fax' => '3456789012',
                'email' => 'member@example.com',
                'url' => 'https://example.com',
                'status' => 0,
                'token' => 'member_token_123',
                'token_expired_at' => FrozenTime::now()->addMinutes(User::TOKEN_EXPIRY_IN_MINUTES),
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 7,
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
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
            [
                'id' => 8,
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
                'deleted' => null,
                'created' => '2024-07-18 03:50:44',
                'modified' => '2024-07-18 03:50:44',
            ],
        ];
        parent::init();
    }
}
