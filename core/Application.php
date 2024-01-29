<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    public Database $db;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Session $session;
    public static string $ROOT_DIR;

    public function __construct($rootPath, array $config) 
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}