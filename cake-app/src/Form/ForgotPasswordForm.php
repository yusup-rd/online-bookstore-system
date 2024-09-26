<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ForgotPassword Form.
 */
class ForgotPasswordForm extends Form
{
    use MailerAwareTrait;

    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('email', 'string');
    }

    /**
     * Form validation builder
     *
     * @param Validator $validator Validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmptyString('email', __('Email is required'))
            ->email('email', false, __('Please enter a valid email address'));
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
        $result = $usersTable->getToken($data['email']);

        if ($result) {
            $data['token'] = $result['token'];
            $this->getMailer('User')->send('sendResetEmail', [$data['email'], $data['token']]);

            return true;
        }

        return false;
    }
}
