<?php

namespace app\controllers;

use gitnjole\simplemvc\Controller;
use gitnjole\simplemvc\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [];
        return $this->render('home', $params);
    }
}