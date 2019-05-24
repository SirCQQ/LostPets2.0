<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();
// require './includes/cio.dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/beforelogin.css">
    <link rel="stylesheet" href="css/tablet.css">
    
    <!-- <link rel="stylesheet" href="./css/secondcssback.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />

    <script src="./js/functions.js"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

    <title>LostPets</title>
</head>

<body>

    <header>

        <img class='logo' src='img/logo3.png' alt="logo">


        <?php
        if (isset($_SESSION['userId'])) {
            ?>

            <div class="icons">
                <img class="form" onclick='formular()' src="./Img/plus.png" alt="Add a lost pet ">
                <img class="not" onclick="notification()" src="./Img/notification.png" alt="Notification">
                <img class="profile" onclick="profile()" src="./Img/BasicProfileImg.png" alt="Profile">
            </div>

            <ul id="notifications" class="hidden">
                <li>notification 1</li>
                <li>notification 2</li>
                <li>notification 3</li>
                <li>notification 4</li>
            </ul>

            <ul id="profile" class="hidden">
                <li>Change profile information</li>
                <li>
                    <form class="logout-form" action="includes/logout.inc.php" method="post">
                        <button type="submit" class="logout" name="logout-submit">Logout</button>
                    </form>
                </li>
            </ul>
            <!-- <div class="burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <div class="nav">
                <p>Formular</p>
                <p>Notifications</p>
                <p>Profile</p>
            </div> -->
        <?php

    } else {
        ?>
            <!-- <div class="login-form"> -->
            <form action="includes/login.inc.php" method="POST" class="login-form">
                <input type="text" id='mail' name="email" placeholder="Email...">
                <!-- <br> -->
                <input type="password" id='pwd' name="pwd" placeholder="Password">
                <!-- <div class="buttons"> -->
                    <button type="submit" class='top-btn login' name="login-submit">Login</button>
                    <!-- <button class='top-btn' onclick="fromRegister()">Sigup</button> -->
                    <button class='top-btn signup' type="button" onclick="fromRegister()">Sigup</button>
                <!-- </div> -->
            </form>

        <?php
    }
    ?>


        <!-- </div> -->
    </header>