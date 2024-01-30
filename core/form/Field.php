<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    protected const TYPE_TEXT = 'text';
    protected const TYPE_PASS = 'password';
    protected const TYPE_NUMBER = 'number';
    protected const TYPE_EMAIL = 'email';
    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
    }
    public function __toString()
    {
        return sprintf('
            <label>%s</label>
            <input type="%s" name="%s" value="%s">
            <div class="invalid-feedback">
                %s
            </div>
        ', 
            $this->model->labels()[$this->attribute] ?? $this->attribute,
            $this->type, 
            $this->attribute, 
            $this->model->{$this->attribute},
            $this->model->getFirstError($this->attribute));
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASS;
        return $this;
    }

    public function textField()
    {
        $this->type = self::TYPE_TEXT;
        return $this;
    }

    public function emailField()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
    public function numberField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }
}