<?php

namespace app\core;

use app\core\db\DBModel;
use app\core\db\Database;

class Application
{
    public Router $router;
    public string $userClass;
    public string $layout = 'main';
    public Request $request;
    public Database $db;
    public ?DBModel $user;
    public Response $response;
    public static Application $app;
    public ?Controller $controller = null;
    public Session $session;
    public static string $ROOT_DIR;

    public function __construct($rootPath, array $config) 
    {
        $this->userClass = $config["userClass"];
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
        
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $userClass = $this->userClass;
            $userInstance = new $userClass();
            $primaryKey = $userInstance->primaryKey();
            $this->user = $userInstance->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }    
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch(\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DBModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}