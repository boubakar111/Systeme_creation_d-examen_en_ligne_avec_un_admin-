<?php

namespace database;

use Database;

class ModelHistoriq
{
    /**
     * @param string|null $email
     * @param int|null $eid
     */

    public function delete(?string $email = null, ?int $eid = null)
    {
        $con = new \Database();
        $pdo = $con->getPdo();
        if ($email) {
            $query = $pdo->prepare("DELETE FROM history WHERE email= ' $email' ") or die('Error');
        } else if ($eid) {
            $query = $pdo->prepare("DELETE FROM history WHERE eid = ' $eid' ") or die('Error');
        } else if ($eid && $email) {
            $query = $pdo->prepare("DELETE FROM `history` WHERE eid='$eid' AND email='$email' ") or die('Error184');
        }

        $query->execute();
    }

    /**
     * @param $email
     * @param $eid
     * @param $date
     *
     */
    public function insertHistorique($email, $eid, $date)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO history (email , eid , score ,`level` ,sahi  , wrong ,`date` )
                                                     VALUES  ( :email , :eid , :score ,:level , :sahi , :wrong, :date)") or die('Error');
        $query->execute([
            'email' => $email,
            'eid' => $eid,
            'score' => '0',
            'sahi' => '0',
            'level' => '0',
            'wrong' => '0',
            'date' => $date
        ]);
    }

    public function findScoreHistorique($eid, $email)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
        $result = $query->fetchAll();

        return $result;

    }

    /**
     * @param $eid
     * @param $email
     * @return array
     *
     */

    public function findHistoriqueBy($eid, $email)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM history WHERE eid=:eid AND email=:email ") or die('Error157');
        $query->execute(['eid' => $eid, 'email' => $email]);
        $result = $query->fetchAll();

        return $result;

    }

    /**
     * @param $eid
     * @param $email
     * @return array
     */
    public function findScorHistoryBy($eid, $email)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT score FROM history WHERE eid= :eid AND email=:email ") or die('Error98');
        $query->execute(['eid' => $eid, 'email' => $email]);
        $result = $query->fetchAll();

        return $result;

    }

    /**
     * @param $email
     * @return array
     */
    public function findHistoryBy($email)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM history WHERE email='$email' ORDER BY date DESC ") or die('Error197');
        $query->execute(['email' => $email]);
        $result = $query->fetchAll();

        return $result;


    }

    /**
     * @param $email
     * @param $eid
     * @param $date
     * @param $hahi
     * @param $level
     * @param $score
     * @return mixed
     */
    public function updateHistoriqueWrong($email, $eid, $date, $level, $score, $wrong)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("UPDATE `history` SET `score`=:score,`level`=:level,`wrong`=:wrong, date=:date WHERE  email =:email AND eid =:eid") or die('Error147');

        $result = $query->execute([
            'score' => $score,
            'level' => $level,
            'wrong' => $wrong,
            'date' => $date,
            'email' => $email,
            'eid' => $eid
        ]);

    }

    public function updateHistoriqueSahi($email, $eid, $date, $level, $score, $sahi)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare( "UPDATE `history` SET `score`= :score,`level`= :level,`sahi`=:sahi, `date`= :date  WHERE  `email` =:email AND eid = :eid") or die('Error124');
        // $query = $pdo->prepare("UPDATE history SET score=:score , `level`=:levle, sahi= :sahi, `date`=:date  WHERE  email =:email AND eid=:eid ") or die('Error125');
        $result = $query->execute([
            'score' => $score,
            'level' => $level,
            'sahi' => $sahi,
            'date' => $date,
            'email' => $email,
            'eid' => $eid
        ]);


    }


}