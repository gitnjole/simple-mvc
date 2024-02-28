<?php
namespace app\controllers;

use app\models\User;
use gitnjole\simplemvc\Request;
use gitnjole\simplemvc\Session;
use gitnjole\simplemvc\Response;
use gitnjole\simplemvc\Controller;
use gitnjole\simplemvc\Application;
use app\models\LoginForm;
use gitnjole\simplemvc\middlewares\AuthMiddleware;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');
                return;
            }
        }

        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $this->setLayout('auth');

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->register()) {
                Application::$app->session->setFlashMessage('success', 'Successfully registered!');
                Application::$app->response->redirect('/');
                exit;
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

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');

    }

}

