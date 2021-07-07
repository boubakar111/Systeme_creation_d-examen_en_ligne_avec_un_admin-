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
$userUs = new ModelUser();
$userCl = new ModelClassement();
$userHi = new \database\ModelHistoriq();
$userQu = new \database\ModelQuestionaire();
$userOp = new \database\ModelOptions();
$userRe = new \database\ModelReponse();
$userQz = new \database\ModelQuiz();
session_start();
if (!(isset($_SESSION['email']))) {
    header("location:login.php");
} else {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    include_once 'Quiz/database/Database.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Online Quiz System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-default title1">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>Online Quiz System</b></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?> ><a href="welcome.php?q=1"><span
                                class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span
                                class="sr-only">(current)</span></a></li>
                <li <?php if (@$_GET['q'] == 2) echo 'class="active"'; ?>><a href="welcome.php?q=2"><span
                                class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
                <li <?php if (@$_GET['q'] == 3) echo 'class="active"'; ?>><a href="welcome.php?q=3"><span
                                class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li <?php echo ''; ?> ><a href="logout.php?q=welcome.php"><span class="glyphicon glyphicon-log-out"
                                                                                aria-hidden="true"></span>&nbsp;Log out</a>
                </li>
            </ul>


        </div>
    </div>
</nav>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (@$_GET['q'] == 1) {
                $result = $userQz->findQuiz();
                echo '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                    <tr><td><center><b>S.N.</b></center></td><td><center><b>Sujet </b></center></td><td><center><b>Total de question</b></center></td><td><center><b>Marks</center></b></td><td><center><b>Action</b></center></td></tr>';
                $c = 1;
                foreach ($result as $key => $row) {
                    $title = $row['title'];
                    $total = $row['total'];
                    $sahi = $row['sahi'];
                    $eid = $row['eid'];
                    $q12 = $userHi->findScorHistoryBy($eid, $email);

                    $rowcount = count($q12);
                    if ($rowcount == 0) {
                        echo '<tr><td><center>' . $c++ . '</center></td><td><center>' . $title . '</center></td><td><center>' . $total . '</center></td><td><center>' . $sahi * $total . '</center></td><td><center><b><a href="welcome.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="btn sub1" style="color:black;margin:0px;background:#1de9b6"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></center></td></tr>';
                    } else {
                        echo '<tr style="color:#99cc32"><td><center>' . $c++ . '</center></td><td><center>' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></center></td><td><center>' . $total . '</center></td><td><center>' . $sahi * $total . '</center></td><td><center><b><a href="update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn sub1" style="color:black;margin:0px;background:red"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Restart</b></span></a></b></center></td></tr>';
                    }
                }
                $c = 0;
                echo '</table></div></div>';
            } ?>

            <?php
            if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
                $eid = @$_GET['eid'];
                $sn = @$_GET['n'];
                $total = @$_GET['t'];
                $q = $userQu->findQesionaireBy($eid, $sn);


                echo '<div class="panel" style="margin:5%">';
                foreach ($q as $key => $row) {
                    $qns = $row['qns'];
                    $qid = $row['qid'];
                    echo '<b>Question &nbsp;' . $sn . '&nbsp;<br /><br />' . $qns . '</b><br /><br />';
                }

                $q = $userOp->findOptionByEid($qid);

                echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal">
                        <br />';
                foreach ($q as $key => $row) {
                    $option = $row['option'];
                    $optionid = $row['optionid'];
                    echo '<input type="radio" name="ans" value="' . $optionid . '">&nbsp;' . $option . '<br /><br />';
                }
                echo '<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Submit</button></form></div>';
            }

            if (@$_GET['q'] == 'result' && @$_GET['eid']) {
                $eid = @$_GET['eid'];
                $q = $userHi->findHistoriqueBy($eid, $email);

                echo '<div class="panel">
                        <center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

                foreach ($q as $key => $row) {
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];
                    echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>' . $qa . '</td></tr>
                                <tr style="color:#99cc32"><td>Bonne réponse&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>' . $r . '</td></tr> 
                                <tr style="color:red"><td>Mauvaise réponse&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>' . $w . '</td></tr>
                                <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
                }
                $q = $userCl->findClassementBy($email);

                foreach ($q as $key => $row) {
                    $s = $row['score'];
                    echo '<tr style="color:#990000"><td>Score Globale&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>' . $s . '</td></tr>';
                }
                echo '</table></div>';
            }
            ?>

            <?php
            if (@$_GET['q'] == 2) {
                $q = $userHi->findHistoryBy($email);

                echo '<div class="panel title">
                        <table class="table table-striped title1" >
                        <tr style="color:black;"><td><center><b>S.N.</b></center></td><td><center><b>Quiz</b></center></td><td><center><b>Question Solved</b></center></td><td><center><b>Right</b></center></td><td><center><b>Wrong<b></center></td><td><center><b>Score</b></center></td>';
                $c = 0;
                foreach ($q as $key => $row) {
                    $eid = $row['eid'];
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];

                    $q23 = $userQz->findQuizBy($eid);

                    foreach ($q23 as $key => $row) {
                        $title = $row['title'];
                    }
                    $c++;
                    echo '<tr><td><center>' . $c . '</center></td><td><center>' . $title . '</center></td><td><center>' . $qa . '</center></td><td><center>' . $r . '</center></td><td><center>' . $w . '</center></td><td><center>' . $s . '</center></td></tr>';
                }
                echo '</table></div>';
            }

            if (@$_GET['q'] == 3) {

                $q = $userCl->findAllClassement();

                echo '<div class="panel title"><div class="table-responsive">
                        <table class="table table-striped title1" >
                        <tr style="color:red"><td><center><b>Classement</b></center></td><td><center><b>Name</b></center></td><td><center><b>Email</b></center></td><td><center><b>Score</b></center></td></tr>';
                $c = 0;

               foreach ($q as $key => $row) {
                    $email = $row['email'];
                    $score = $row['score'];

                    $q12 = $userUs->findUserBy($email);

                   foreach ($q12 as $key => $row ) {
                        $name = $row['name'];
                    }
                    $c++;
                    echo '<tr><td style="color:black"><center><b>' . $c . '</b></center></td><td><center>' . $name . '</center></td><td><center>' . $email . '</center></td><td><center>' . $score . '</center></td></tr>';
                }
                echo '</table></div></div>';
            }
            ?>
</body>
</html>
