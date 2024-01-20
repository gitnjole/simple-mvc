<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => 'haiii'
        ];
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

    public function formHandler()
    {
        return 'Handling submitted data.';
    }


}