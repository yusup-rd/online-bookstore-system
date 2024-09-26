<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $role
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $fax
 * @property string $email
 * @property string|null $url
 * @property bool $status
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime|null $token_expired_at
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
{
    const ROLE_ADMIN = 'admin';
    const ROLE_ASSISTANT = 'assistant';
    const ROLE_PUBLISHER = 'publisher';
    const ROLE_MEMBER = 'member';

    const USER_ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_ASSISTANT => 'Assistant',
        self::ROLE_PUBLISHER => 'Publisher',
        self::ROLE_MEMBER => 'Member',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const USER_STATUSES = [
        self::STATUS_INACTIVE => 'Restricted',
        self::STATUS_ACTIVE => 'Allowed',
    ];

    const TOKEN_EXPIRY_IN_MINUTES = 16;

    /**
     * Check if user is admin
     *
     * @param string $role get user role
     * @return bool
     */
    public static function isAdmin($role)
    {
        return $role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is assistant
     *
     * @param string $role get user role
     * @return bool
     */
    public static function isAssistant($role)
    {
        return $role === self::ROLE_ASSISTANT;
    }

    /**
     * Check if user is publisher
     *
     * @param string $role get user role
     * @return bool
     */
    public static function isPublisher($role)
    {
        return $role === self::ROLE_PUBLISHER;
    }

    /**
     * Check if user is publisher
     *
     * @param string $role get user role
     * @return bool
     */
    public static function isMember($role)
    {
        return $role === self::ROLE_MEMBER;
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'login' => true,
        'password' => true,
        'role' => true,
        'name' => true,
        'address' => true,
        'phone' => true,
        'fax' => true,
        'email' => true,
        'url' => true,
        'status' => true,
        'token' => true,
        'token_expired_at' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * _setPassword method to convert into encrypted password.
     *
     * @param string $password Password to be hashed.
     * @return false|string|void Hashed password.
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
