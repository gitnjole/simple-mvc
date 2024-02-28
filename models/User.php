<?php

namespace app\models;

use app\core\DBModel;

class User extends DBModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public string $id = '';
    public string $username = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';
    public string $join_date = '';

    public function register()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->insertUser();
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'username' => [[self::RULE_REQUIRED], [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_PASS_LEN, 'min' => 3]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }

    public function attributes(): array
    {
        return ['username', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
            'email' => 'E-mail'
        ];
    }
}
