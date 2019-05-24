<?php

if (isset($_POST['login-submit'])) {

    // require 'dbh.inc.php';
    require 'cio.dbh.inc.php';
    $mail = $_POST['email'];
    $pwd = $_POST['pwd'];
    if (empty($mail)) {
            header("Location: ../?error=emplyEmail");
            exit();
        } else if (empty($pwd)) {
            header("Location: ../?error=emplypass");
            exit();
        } else {
         login($mail,$pwd);
    }
} else {
    header("Location: ../");
    exit();
}
