<?php

namespace app\models;

use app\core\DBModel;

class User extends DBModel
{
    public string $username = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $email = '';

    public function register()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->insertUser();
    }

    public function tableName(): string
    {
        return 'users';
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

    public function attributes(): array
    {
        return ['username', 'email', 'password'];
    }
}
