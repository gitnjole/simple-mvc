<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    public static function Begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function End()
    {
        return '</form>';
    }

    public function Field(Model $model, $attribute)
    {
        return new Field($model, $attribute);
    }
}