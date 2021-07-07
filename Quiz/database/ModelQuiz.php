<?php

namespace database;

use Database;

class ModelQuiz
{
    /**
     * insert
     */

    public function insertQuiz($eid, $name, $sahi, $wrong, $total, $date)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("INSERT INTO quiz (eid, title, sahi, wrong, total, date) 
                               VALUES  (:eid , :title, :sahi, :wrong, :total, :date )");
        $query->execute(['eid' => $eid,
            'title' => $name,
            'sahi' => $sahi,
            'wrong' => $wrong,
            'total' => $total,
            'date' => $date
        ]);

    }


    /**
     * @return array alle Quiz
     *
     */
    public function findQuiz()
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("SELECT * FROM quiz ORDER BY date DESC") or die('Error');
        $query->execute();
        $allQuiz = $query->fetchAll();

        return $allQuiz;
    }

    /**
     * @param $qid
     * delete quiz
     */
    public function deleteQuizBy($eid)
    {

        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare("DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
        $query->execute();
    }

    /**
     * @param $eid
     * @return array
     */
    public function findQuizBy($eid)
    {
        $con = new Database();
        $pdo = $con->getPdo();
        $query = $pdo->prepare(" SELECT * FROM quiz WHERE eid = :eid")  or die('Error208');
        $query->execute(['eid' => $eid]);
        $resultAnswer = $query->fetchAll();
        return $resultAnswer;
    }
}