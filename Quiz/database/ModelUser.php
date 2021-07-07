<?php

namespace database;

use Database;

require_once('Database.php');

class ModelUser
{


    /**
     * @param $eid
     * @param $sn
     * @return array liste des questions
     */
    public function findQuestionByQid($eid, $sn)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
        $query->execute();
        $question = $query->fetchAll(PDO::FETCH_ASSOC);

        return $question;
    }

    /**
     * @param $qid
     * @return array des option
     */
    public function optionByEid($qid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM modelOprion WHERE qid='$qid'");
        $query->execute();
        $option = $query->fetchAll(PDO::FETCH_ASSOC);

        return $option;
    }


    /**
     * @return array
     *
     */
    public function classementParScor()
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM rank ORDER BY score DESC") or die('Error223');
        $query->execute();
        $score = $query->fetchAll();

        return $score;
    }


    /**
     * @return mixed
     * @Return array all Users
     */
    public function findAllUsers()
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM user ");
        $query->execute();
        $user = $query->fetchAll();

        return $user;

    }

    /**
     * @param $email
     * @param $pass
     * @return  user
     */
    function findUser($email, $pass)
    {
        $con = new \Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM user WHERE email='$email' and password='$pass'");
        $query->execute(['email' => $email, 'password' => $pass]);
        $user = $query->fetchAll();

        return $user;

    }

    /**
     * @return resultat requete insert
     *inset user
     */
    public function saveUser($name, $email, $password, $etablissemnt, $role, $isActif)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO user set name='$name',email='$email',password='$password', etablissement='$etablissemnt' , role='$role' , isActif ='$isActif'") or die('Error231');
        $query->execute();
        $user = $this->findUserBy($email);
        return $user;
    }

    /**
     * @param $email
     * @return array
     *
     */
    public function findUserBy($email)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM user WHERE email=:email") or die('Error231');
        $query->execute(['email' => $email]);
        $score = $query->fetchAll();

        return $score;
    }

    public function deleteUserBy($email)
    {

        $con = new \Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM user WHERE email='$email' ") or die('Error231');
        $query->execute();
    }
}