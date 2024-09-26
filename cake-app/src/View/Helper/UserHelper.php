<?php
/**
 * @var \App\Model\Entity\User $user
 */
namespace App\View\Helper;

use App\Model\Entity\User;
use Cake\View\Helper;

/**
 * User helper
 *
 * @property \Cake\View\Helper\FormHelper $Form
 */
class UserHelper extends Helper
{
    public $helpers = ['Form'];

    /**
     * displayRoleInput method
     *
     * @param array $sessionUser Session user
     * @return string|void
     */
    public function displayRoleInput($sessionUser)
    {
        if (User::isAdmin($sessionUser['role'])) {
            return $this->Form->control('role', [
                'type' => 'select',
                'options' => User::USER_ROLES,
            ]);
        }

        if (User::isAssistant($sessionUser['role'])) {
            return $this->Form->control('role', [
                'type' => 'select',
                'options' => [User::ROLE_PUBLISHER => User::USER_ROLES[User::ROLE_PUBLISHER]],
            ]);
        }
    }

    /**
     * displayStatusInput method
     *
     * @param array $sessionUser Session user
     * @return string|null
     */
    public function displayStatusInput($sessionUser)
    {
        if (User::isAdmin($sessionUser['role'])) {
            return $this->Form->control('status', ['options' => User::USER_STATUSES]);
        }

        return null;
    }
}
