<?php

namespace database;

use Database;

class ModelClassement


{
    public function findAllClassement()
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM rank ORDER BY score DESC ");
        $query->execute();
        $score = $query->fetchAll();
        return $score;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findClassementBy($email)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM rank WHERE email= :email ") or die('Error157');
        $query->execute(['email' => $email]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $email
     * @param $score
     * @param $date
     */
    public function insertClassement($email, $score, $date)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO rank (email , score ,time  )
                                                   VALUES  ( :email , :score , :datee)") or die('Error165');
        $query->execute([
            'email' => $email,
            'score' => $score,
            'datee' => $date
        ]);
    }

    public function updateClassement($sun, $email, $date)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("UPDATE  `rank` SET `score`=:sun  ,`time`= :date  WHERE email=:email") or die('Error174');
        $result = $query->execute([
            'sun' => $sun,
            'email' => $email,
            'date' => $date
        ]);
    }

    /**
     * @param $email
     * delete classement  pas un email
     */
    public function delete($email)
    {
        $con = new \Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM rank WHERE email= :email ") or die('Error');
        $query->execute(['email' => $email]);
    }
}