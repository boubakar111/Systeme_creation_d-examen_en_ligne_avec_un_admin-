<?php

namespace database;

use Database;

class ModelOptions
{

    /**
     * @param $qid
     * delete option
     */
    public function deletOption($qid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM options WHERE qid='$qid'") or die('Error');
        $query->execute();

    }


    /**
     * @param $qid
     * @param $option
     * @param $optionid
     * @return void
     */
    public function insertOption($qid,  ?string $option="" , ?string $optionid="" )
    {
        $con = new Database();
        $pdo = $con->getPdo();
            $query = $pdo->prepare( "INSERT INTO options (qid, `option`,optionid ) 
                                             VALUES  (:qid , :opt, :optid);");
            $query->execute( [
                'qid' => $qid,
                'opt' => $option,
                'optid' => $optionid ]);

    }

    /**
     * @param $qid
     * @return array des option
     */
    public function findOptionByEid($qid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM options WHERE qid = :qid  " );
        $query->execute(['qid'=>$qid]);
        $option = $query->fetchAll();

        return $option;
    }

    public function findQestionsBy($eid , $sn){

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
        $query->execute();
        $option = $query->fetchAll();

        return $option;

    }

}