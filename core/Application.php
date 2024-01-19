<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    public ResponseCode $response;
    public static Application $app;
    public static string $ROOT_DIR;

    public function __construct($rootPath) 
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new ResponseCode();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}