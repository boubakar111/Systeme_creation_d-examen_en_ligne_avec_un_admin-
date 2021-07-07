<?php

namespace database;

use Database;

class ModelReponse
{
    /**
     * @param $qid
     * delete option
     */
    public function deletResponse($qid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM answer WHERE qid='$qid' ") or die('Error');
        $query->execute();

    }

    /**
     * @param $qid
     * @param $ansid
     */

    public function insertReponse($qid, $ansid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO answer (qid , ansid )
                                                   VALUES  ( :qid, :ansid)");

        $query->execute([
            'qid' => $qid,
            'ansid' => $ansid]);

    }


    /**
     * @param $eid
     * @return array
     */
    public function findResponseBy($qid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM answer WHERE qid =:qid") or die('Error');
        $query->execute(['qid' => $qid]);
        $resultAnswer = $query->fetchAll();

        return $resultAnswer;
    }
}