<?php

require_once('../database/ModelUser.php');
$user = new \database\ModelUser();
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    session_destroy();
}

$ref = @$_GET['q'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $email = stripslashes($email);
            $email = addslashes($email);
            $pass = stripslashes($pass);
            $pass = addslashes($pass);

            $result = $user->findUser($email, $pass);
            if (count($result) != 0) {

                $_SESSION['logged'] = $email;
                foreach ($result as $row => $link) {

                    $_SESSION['name'] = $link['name'];
                    $_SESSION['etablissement'] = $link['etablissement'];
                    $_SESSION['email'] = $link['email'];
                    $_SESSION['isActif'] = $link['isActif'];

                    if ($link['role'] === "admin") {
                        if ($link['isActif'] === "1") {
                            $_SESSION['role'] = $link['role'];
                            $_SESSION['actif'] = $link['isActif'];
                            header('location:espace_admin.php');
                        } else {
                            echo "<center><h3><script>alert('Désole .. votre compte est desactiver ..!! ');</script></h3></center>";
                            header("refresh:0;url=../../login.html");
                        }
                    } else if ($link['role'] === "utilisateur") {
                        if ($link['isActif'] === "1") {
                            $_SESSION['role'] = $link['role'];
                            header('location:../../welcome.php?q=1');
                        } else {
                            echo "<center><h3><script>alert('Désole .. votre compte est desactiver contacter l\'administrateur..!!');</script></h3></center>";
                            header("refresh:0;url=../../login.html");
                        }
                    }
                }
            } else {
                echo "<center><h3><script>alert('Désole .. Probleme dans votre email  (or) Mot de passe ');</script></h3></center>";
                header("refresh:0;url=../../login.html");
            }

        }
    }
}
