<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\MailerAwareTrait;
use Cake\Validation\Validator;

/**
 * Email Form.
 * @property $Users
 */
class EmailForm extends Form
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
        return $schema
            ->addField('subject', 'string')
            ->addField('message', 'text');
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
            ->notEmptyString('subject', __('Subject is required'))
            ->notEmptyString('message', __('Message is required'));
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        $user = $data['user'];
        $to = $user->email;
        $subject = $data['subject'];
        $message = $data['message'];

        $this->getMailer('User')->send('sendToPublisher', [$to, $subject, $message]);

        return true;
    }
}
