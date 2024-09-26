<?php
namespace App\Model\Validation;

use Cake\Validation\ValidationSet;

/**
 * PasswordValidationSet
 */
class PasswordValidationSet extends ValidationSet
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->add('minLength', [
            'rule' => ['minLength', 8],
            'message' => 'Password must be at least 8 characters long',
        ]);
        $this->add('passwordStrength', [
            'rule' => function ($value) {
                return preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W)/', $value) > 0;
            },
            'message' => 'Password must contain at least one letter, one number, and one special character',
        ]);
    }
}
