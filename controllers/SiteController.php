<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [];
        return $this->render('home', $params);
    }

    public function features()
    {
        return $this->render('features');
    }

    public function form()
    {
        return $this->render('form');
    }

    public function formHandler(Request $request)
    {
        $body = $request->getBody();
        print_r($body);
    }

}