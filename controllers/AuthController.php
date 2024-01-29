<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $user = new User();
        $this->setLayout('auth');

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->register()) {
                return 'Success';
            }

            return $this->render('register', [
                'model' => $user
            ]);
        }

        // Render the registration page for GET requests.
        return $this->render('register', [
            'model' => $user
        ]);
    }

}

