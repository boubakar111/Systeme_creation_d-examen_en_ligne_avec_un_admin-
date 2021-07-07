<?php


class Database
{

    /**
     * returne la connexion  a la base de donnee
     * @retun PDO
     */
    public function getPdo(): PDO
    {



            $pdo = new PDO('mysql:host=localhost;dbname=sourcecodester_exam;charset=utf8', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);


        return $pdo;
    }
}

