<?php
require './includes/CSV.php';
// require './includes/cio.dbh.inc.php';


session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="https://peterolson.github.io/BigInteger.js/BigInteger.min.js"></script>
    <title>LostPets</title>
</head>

<body>
    <header>
        <img class='logo' src='img/logo3.png' alt="logo">
        <?php if (isset($_SESSION['userId'])) {
            echo "<div id=\"userId\" hidden>" . $_SESSION['userId'] . "</div>";
            CSV();
        } ?>
        <?php
        if (isset($_SESSION['userId'])) {
            ?>
            <div class="icons">
                <img class="form" onclick='formular()' src="./Img/plus.png" alt="Add a lost pet ">
                <img class="not" onclick="notification()" src="./Img/notification.png" alt="Notification">
                <img class="profile" onclick="profile()" alt="ProfileIMG" id='profile_pic'>
            </div>
            <ul id="notifications" class="hidden">
                
            </ul>
            <ul id="profile" class="hidden">
                <li><a href="./Statistici_Zone_Animale_pierdute_HTML"><button>Statistici in format HTML</button></a></li>
                <li><a href="./Statistici_Zone_Animale_pierdute_PDF"><button>Statistici in format PDF</button></a></li>
                <li><a href="./Files/Statistici.csv" download><button>Statistici in format CSV</button></a></li>
                <li>
                    <form class="logout-form" action="includes/logout.inc.php" method="post">
                        <button type="submit" class="logout" name="logout-submit">Logout</button>
                    </form>
                </li>
            </ul>
        <?php
    } else {
        ?>
            <form class="login-form" onsubmit="event.preventDefault(); login()">
                <input type="text" id='mail' name="email" placeholder="Email...">
                <input type="password" id='pwd' name="pwd" placeholder="Password">
                <button type="submit" class='top-btn login' name="login-submit">Login</button>
                <button class='top-btn signup' type="button" onclick="fromRegister()">Sigup</button>
            </form>
        <?php
    }
    ?>
    </header>