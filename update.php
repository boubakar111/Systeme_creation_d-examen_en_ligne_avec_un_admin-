<?php

use database\ModelClassement;
use database\ModelUser;

require_once('Quiz/database/ModelUser.php');
require_once('Quiz/database/ModelClassement.php');
require_once('Quiz/database/ModelHistoriq.php');
require_once('Quiz/database/ModelQuestionaire.php');
require_once('Quiz/database/ModelOptions.php');
require_once('Quiz/database/ModelReponse.php');
require_once('Quiz/database/ModelQuiz.php');
$adminUs = new ModelUser();
$adminCl = new ModelClassement();
$adminHi = new \database\ModelHistoriq();
$adminQu = new \database\ModelQuestionaire();
$adminOp = new \database\ModelOptions();
$adminRe = new \database\ModelReponse();
$adminQz = new \database\ModelQuiz();


session_start();
$email = $_SESSION['email'];

// supression d'un utilisateur  avec son score et  teste inclus
if (isset($_SESSION['role'])) {
    if (@$_GET['demail'] && $_SESSION['role'] == 'admin') {
        $demail = @$_GET['demail'];
        $r1 = $adminCl->delete($demail);
        $r2 = $adminHi->delete($demail);
        $result = $adminUs->deleteUserBy($demail);
        header("location:Quiz/admin/espace_admin.php?q=1");
    }
}

if (isset($_SESSION['role'])) {
    if (@$_GET['q'] == 'quizRM' && $_SESSION['role'] == 'admin') {
        $eid = @$_GET['eid'];
        $result = $adminQu->findQesionaireBy($sn = null, $eid);
        foreach ($result as $key => $row) {
            $qid = $row['qid'];
            $r1 = $adminOp->deletOption($qid);
            $r2 = $adminRe->deletResponse($qid);
        }
        $r3 = $adminQu->deleteQuestionBy($eid);
        $r4 = $adminQz->deleteQuizBy($eid);
        $r4 = $adminHi->delete($eid);
        header("location:Quiz/admin/espace_admin.php?q=5");
    }
}

if (isset($_SESSION['role'])) {
    if (@$_GET['q'] == 'addquiz' && $_SESSION['role'] == 'admin') {
        $name = $_POST['name'];
        $name = ucwords(strtolower($name));
        $total = $_POST['total'];
        $sahi = $_POST['right'];
        $wrong = $_POST['wrong'];
        $id = uniqid();
        $date = date("Y-m-d H:i:s");

        $q3 = $adminQz->insertQuiz($id, $name, $sahi, $wrong, $total, $date);
        header("location:Quiz/admin/espace_admin.php?q=4&step=2&eid=$id&n=$total");
    }
}

if (isset($_SESSION['role'])) {
    if (@$_GET['q'] == 'addqns' && $_SESSION['role'] == 'admin') {
        $n = @$_GET['n'];
        $eid = @$_GET['eid'];
        $ch = @$_GET['ch'];
        for ($i = 1; $i <= $n; $i++) {
            $qid = uniqid();
            $qns = $_POST['qns' . $i];
            $q3 = $adminQu->insertQuestion($eid, $qid, $qns, $ch, $i);
            $oaid = uniqid();
            $obid = uniqid();
            $ocid = uniqid();
            $odid = uniqid();
            $a = $_POST[$i . '1'];
            $b = $_POST[$i . '2'];
            $c = $_POST[$i . '3'];
            $d = $_POST[$i . '4'];
            $qa = $adminOp->insertOption($qid, $a, $oaid);
            $qb = $adminOp->insertOption($qid, $b, $obid);
            $qc = $adminOp->insertOption($qid, $c, $ocid);;
            $qd = $adminOp->insertOption($qid, $d, $odid);;
            $e = $_POST['ans' . $i];
            switch ($e) {
                case 'a':
                    $ansid = $oaid;
                    break;
                case 'b':
                    $ansid = $obid;
                    break;
                case 'c':
                    $ansid = $ocid;
                    break;
                case 'd':
                    $ansid = $odid;
                    break;
                default:
                    $ansid = $oaid;
            }
            $qans = $adminRe->insertReponse($qid, $ansid);
        }
        header("location:Quiz/admin/espace_admin.php?q=0");
    }
}

if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
    $eid = @$_GET['eid'];
    $sn = @$_GET['n'];
    $total = @$_GET['t'];
    $ans = $_POST['ans'];
    $qid = @$_GET['qid'];

    $date = date("Y-m-d H:i:s");
    $q = $adminRe->findResponseBy($qid);

    foreach ($q as $key => $row) {

        $ansid = $row['ansid'];
    }
    if ($ans == $ansid) {
        $q = $adminQz->findQuizBy($eid);
        foreach ($q as $key => $row) {
            $sahi = $row['sahi'];
        }
        if ($sn == 1) {

            $q = $adminHi->insertHistorique($email, $eid, $date);
        }
        $q = $adminHi->findHistoriqueBy($eid, $email);
        foreach ($q as $key => $row) {
            $s = $row['score'];
            $r = $row['sahi'];
        }
        $r++;
        $s = $s + $sahi;
        $q = $adminHi->updateHistoriqueSahi($email, $eid, $date, $s, $sahi ,$sn);
    } else {
        $q = $adminQz->findQuizBy($eid);
        foreach ($q as $key => $row) {
            $wrong = $row['wrong'];
        }
        if ($sn == 1) {
            $q = $adminHi->insertHistorique($email, $eid, $date);
        }
        $q = $adminHi->findHistoriqueBy($eid, $email);

        foreach ($q as $key => $row) {
            $s = $row['score'];
            $w = $row['wrong'];
        }
        $w++;
        $s = $s - $wrong;

        $q = $adminHi->updateHistoriqueWrong($email, $eid, $date, $s, $w ,$sn);

    }
    if ($sn != $total) {
        $sn++;
        header("location:welcome.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error152');
    } else if ($_SESSION['role'] != 'suryapinky') {
        $q = $adminHi->findHistoriqueBy($eid, $email);
        foreach ($q as $key => $row) {
            $s = $row['score'];
        }
        $q = $adminCl->findClassementBy($email);
        $rowcount = count($q);
        if ($rowcount == 0) {

            $q2 = $adminCl->insertClassement($email, $s, $date);
        } else {
            foreach ($q as $key => $row) {
                $sun = $row['score'];
            }
            $sun = $s + $sun;
            $q = $adminCl->updateClassement($sun, $email, $date);
        }
        header("location:welcome.php?q=result&eid=$eid");
    } else {
        header("location:welcome.php?q=result&eid=$eid");
    }
}

if (@$_GET['q'] == 'quizre' && @$_GET['step'] == 25) {
    $eid = @$_GET['eid'];
    $n = @$_GET['n'];
    $t = @$_GET['t'];
    $q = $adminHi->findHistoriqueBy($eid, $email);
    foreach ($q as $key => $row) {
        $s = $row['score'];
    }
    $q = $adminHi->delete($email, $eid);
    $q = $adminCl->findClassementBy($email);

   foreach ( $q as $key =>$row ) {
        $sun = $row['score'];
    }
   var_dump($sun);
    $sun = $sun - $s;
    $date = date("Y-m-d H:i:s");
    $q = $adminCl->updateClassement($sun, $email, $date);
    header("location:welcome.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}