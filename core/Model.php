<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_MATCH = 'match';
    public const RULE_EMAIL = 'email';
    public const RULE_PASS_LEN = 'min';
    public const RULE_UNIQUE = 'unique';

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                /**
                 * Check which rules were violated
                 */
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_PASS_LEN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_PASS_LEN, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE 
                                                                $uniqueAttribute = :attribute");
                    $statement->bindValue(":attribute", $value);
                    $statement->execute();
                    $userRecord = $statement->fetchObject();

                    if ($userRecord) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessage()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message; 
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => 'This field is required.',
            self::RULE_EMAIL => 'This field must be a valid email address.',
            self::RULE_MATCH => 'The passwords must match.',
            self::RULE_PASS_LEN => 'The password can not be shorter than {min} characters.',
            self::RULE_UNIQUE => 'Must be unique.'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

    public function labels(): array
    {
        return [];
    }
}

