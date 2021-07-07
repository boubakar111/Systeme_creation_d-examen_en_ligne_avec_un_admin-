<?php

namespace database;

use Database;

class ModelQuestionaire
{

    public function findQesionaireBy( $eid , $sn )
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare ("SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' " ) or die('Error');
        $query->execute();
        $question = $query->fetchAll();

        return $question;
    }

    /**
     * @param $qid
     * delete option
     */
    public function deleteQuestionBy($eid)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM questions WHERE eid='$eid' ") or die('Error');
        $query->execute();
    }

    public function insertQuestion($eid, $qid, $qns, $ch, $i)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO questions (eid, qid, qns, choice, sn)
                               VALUES  (:eid , :qid, :qns, :choice, :sn)");
        $query->execute([
            'eid' => $eid,
            'qid' => $qid,
            'qns' => $qns,
            'choice' => $ch,
            'sn' => $i
        ]);
    }
}