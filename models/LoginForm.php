<?php

namespace app\models;

use app\core\Model;
use app\core\Application;

class LoginForm extends Model
{
    public $username = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = self::findOne(['username' => $this->username]);
        if (!$user) {
            $this->addError('username', 'Username not found.');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect.');
            return false;
        }

        return Application::$app->login($user);
    }
}