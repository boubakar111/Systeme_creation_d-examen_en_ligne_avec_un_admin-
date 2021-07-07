<?php

use database\ModelUser;

require_once('Quiz/database/ModelUser.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $name = $_POST['name'];
    $name = stripslashes($name);
    $name = addslashes($name);

    $email = $_POST['email'];
    $email = stripslashes($email);
    $email = addslashes($email);

    $password = $_POST['password'];
    $password = stripslashes($password);
    $password = addslashes($password);

    $etablissement = $_POST['etablissement'];
    $etablissement = stripslashes($etablissement);
    $etablissement = addslashes($etablissement);

    $role= "utilisateur";
    $isActif ="1";

    $pdo = new ModelUser();
    $result = $pdo->findUserBy($email);

    if (count($result) != 0) {

        echo "<center><h3><script>alert('Désole .. Cet e-mail est déjà enregistré ..!!');</script></h3></center>";
        header("refresh:0;url=register.html");
    } else {
        $user = $pdo->saveUser($name, $email, $password, $etablissement ,$role , $isActif);
        if (count($user) != 0) {
            session_start();
            echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
            header('location:welcome.php?q=1');
        }


    }

}