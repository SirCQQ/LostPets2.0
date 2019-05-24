<?php
require 'header.php';

?>

<main>
    <?php
    if (isset($_SESSION['userId'])) {

        ?>
        <!-- <p class='show-me'> You are logged in!</p> -->
        <div class="cards">

            <?php
            require './includes/cio.dbh.inc.php';
            getpets();
            ?>

        </div>
        <div class="hidden" id="input">
            <form action="#" method="post">
                <input type="text" name="name" id="animalName" placeholder="Nume animal">
                <br>
                <input type="text" name="animal" id="animal" placeholder="Ex. Pisica, caine, etc.">
                <br>
                <textarea rows="2" name="detalii" form="inputs" placeholder="Zgarda, medalion, semne distincte "></textarea>
                <br>
                <input type="text" name="zona" id="zona" placeholder="Zona in care a fost pierdut ">
                <br>
                <input type="number" name="recompensa" id="recompensa" placeholder="Recompensa">
                <br>
                <input type="file" name="img" id="img">
                <br>
                <div id="harta-pierdut"></div>
                <br>
                <input type="submit" value="Submit">
            </form>
        </div>
        <div id="mapid"></div>
        <div id="maplost"></div>
        <script src="./js/map.js"></script>

    <?php
} else {
    ?>
        <div id="register" class="hidden">
            <?php

            if (isset($_GET['signup']) == 'success') {
                echo '<p class="success">Singup successful!</p>';
            } else if (isset($_GET['error']) == 'emptyfield') {
                echo '<p class="error">Not all fields are completed! </p>';
            } else if (isset($_GET['error']) == 'invalidall') {
                echo '<p class="error">All fields are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumeprenumenrtel') {

                echo '<p class="error">Last name , first name and phone number are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumeprenumeemail') {

                echo '<p class="error">Last name, first name and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumenrtelemail') {

                echo '<p class="error">Last name, phone number and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidprenumenrtelemail') {

                echo '<p class="error">First name, phone number and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumeprenume') {

                echo '<p class="error">First and last name are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumenrtel') {

                echo '<p class="error">Last name and phone number are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnumeemail') {

                echo '<p class="error">Last name and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidprenumenrtel') {

                echo '<p class="error">First name and phone number are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidprenumeemail') {

                echo '<p class="error">First name and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidnrtelemail') {

                echo '<p class="error">Phone number and email are invalid! </p>';
            } else if (isset($_GET['error']) == 'invalidemail') {

                echo '<p class="error">Invalid email! </p>';
            } else if (isset($_GET['error']) == 'invalidname') {

                echo '<p class="error">Invalid last name! </p>';
            } else if (isset($_GET['error']) == 'prenumeinvalid') {

                echo '<p class="error">Invalid first name! </p>';
            } else if (isset($_GET['error']) == 'invalidnrtel') {

                echo '<p class="error">Invalid phone number! </p>';
            } else if (isset($_GET['error']) == 'passwordcheck') {

                echo '<p class="error">Passwords does not match! </p>';
            } else if (isset($_GET['error']) == 'sqlerror') {

                echo '<p class="error">Server error! </p>';
            } else if (isset($_GET['error']) == 'emailexists') {

                echo '<p class="error">Email already exists! </p>';
            }
            ?>
            <form action="includes/signup.inc.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nume" placeholder="Nume">
                <br>
                <input type="text" name="prenume" placeholder="Prenume">
                <br>
                <input type="text" name="numarTelefon" placeholder="Numer de telefon">
                <br>
                <input type="email" name="email" placeholder="Email">
                <br>
                <input type="password" name="pass" placeholder="Password">
                <br>
                <input type="password" name="pass2" placeholder="Confirm Password">
                <br>
                <a>Alege o poza pentru profil</a>
                <br>
                <input class="file" type="file" name="prfImg"><br>
                <input class="file2" type="submit" name="signup-submit" value="Register">
            </form>
        </div>
    <?php

}
?>


</main>

<?php

require 'footer.php';
?>