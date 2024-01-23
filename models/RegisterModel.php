<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $username = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $email = '';

    public function register()
    {
        return 'Creating new user';
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_PASS_LEN, 'min' => 8]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }
}
