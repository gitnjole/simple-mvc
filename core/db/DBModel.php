<?php

namespace app\core\db;

use app\core\Model;
use app\core\Application;

abstract class DBModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function insertUser()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).")
                                    VALUES (".implode(',', $params).")");
        foreach  ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
 
        $sqlStatement = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $query = self::prepare("SELECT * FROM $tableName WHERE $sqlStatement");
        foreach ($where as $key => $item) {
            $query->bindValue(":$key", $item);
        }

        $query->execute();
        return $query->fetchObject(static::class);
    }

    public function prepare($sqlStatement)
    {
        return Application::$app->db->pdo->prepare($sqlStatement);
    }
}