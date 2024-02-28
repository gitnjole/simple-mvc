<?php

use gitnjole\simplemvc\Application;

class Migration01_initial
{
    public function Lift()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                status SMALLINT NOT NULL,
                join_date TIMESTAMP DEFAULT current_timestamp);
                ";
        $db->pdo->exec($SQL);
    }

    public function Drop()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}