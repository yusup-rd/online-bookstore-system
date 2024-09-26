<?php
namespace App\Form;

use App\Model\Validation\PasswordValidationSet;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ResetPassword Form.
 */
class ResetPasswordForm extends Form
{
    public $message = 'Something went wrong.';

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('password', ['type' => 'string'])
            ->addField('confirm_password', ['type' => 'string']);
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmptyString('password', __('Password is required'))
            ->add('password', (new PasswordValidationSet())->rules())
            ->sameAs('confirm_password', 'password', __('Passwords do not match'));
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');

        try {
            $token = $data['token'];

            /**
             * @var \App\Model\Entity\User $user
             */
            $user = $usersTable->find()
                ->where(['token' => $token])
                ->first();

            if (!$user || $user->token_expired_at->isPast()) {
                throw new \InvalidArgumentException(__('Token has expired or is invalid.'));
            }

            $user = $usersTable->patchEntity($user, $data);
            $user->token = null;
            $user->token_expired_at = null;

            if (!$usersTable->save($user)) {
                throw new \RuntimeException(__('Unable to reset password.'));
            }

            $this->message = __('Password has been reset.');

            return true;
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
        }

        return false;
    }
}
