<?php
require 'header.php';

?>

<main>
    <?php
    if (isset($_SESSION['userId'])) {

        ?>
        <!-- <p class='show-me'> You are logged in!</p> -->
        <div class="cards">

        </div>
        <div class="hidden" id="input">
            <form action="./includes/formPet.inc.php" method="post" enctype="multipart/form-data">
                <?php if (isset($_SESSION['userId'])) {
                    echo "<input name='userId' hidden value=\"" . $_SESSION['userId'] . "\"/>";
                } ?>
                <input type="text" name="name" id="animalName" placeholder="Nume animal">
                <br>
                <input type="text" name="animal" id="animal" placeholder="Ex. Pisica, caine, etc.">
                <br>
                <textarea rows="2" name="detalii" placeholder="Zgarda, medalion, semne distincte "></textarea>
                <br>
                <select  name="zona" id="zona" 
                 placeholder="Zona in care a fost pierdut ">
                 <option >Copou</option>
                    <option >Ticau</option>
                    <option >Zimbru</option>
                    <option >Sararie</option>
                    <option >Podu de fier</option>
                    <option >Agronomie</option>
                    <option >Targu cucului</option>
                    <option >Tudor vladimirescu</option>
                    <option >Bucsinescu</option>
                    <option >Tatarasi nord</option>
                    <option >Tatarasi sud</option>
                    <option >Moara de vant</option>
                    <option >Ciurchi</option>
                    <option >Metalurgie</option>
                    <option >Aviatiei</option>
                    <option >Zona industriala dancu</option>
                    <option >Baza 3</option>
                    <option >Bularga</option>
                    <option >Bucium</option>
                    <option >Socola</option>
                    <option >Frumoasa</option>
                    <option >Manta rosie</option>
                    <option >Podu ros</option>
                    <option >Dimitrie cantemir</option>
                    <option >Tesatura</option>
                    <option >Nicolina 1</option>
                    <option >Nicolina 2</option>
                    <option >Cug 1</option>
                    <option >Cug 2</option>
                    <option >Galata 1</option>
                    <option >Galata 2</option>
                    <option >Podu de piatra</option>
                    <option >Zona industriala sud</option>
                    <option >Mircea cel batran</option>
                    <option >Alexandru cel bun</option>
                    <option >Gara</option>
                    <option >Dacia</option>
                    <option >Pacurari</option>
                    <option >Canta</option>
                    <option >Pacuret</option>
                    <option >Moara de foc</option>
                    <option>Alta locatie</option>

                </select>
                <br>
                <input type="number" name="recompensa" step="0.1" id="recompensa" placeholder="Recompensa">
                <input type="number" value="" name="latLostForm" hidden id="latLostForm">
                <input type="number" value="" name="lngLostForm" hidden id="lngLostForm">
                <br>
                <input class="file" type="file" name="prfImg"><br>
                <h2>Apasa pe harta pentru o pozitie mai exacta</h2>
                <br>
                <input type="submit" name="pet-submit" value="Submit">
            </form>
        </div>


        <div class="hidden " id="found-pet">
            <div >
                <h3> Click on the map where you find the pet</h3>
                <?php if (isset($_SESSION['userId'])) {
                    echo "<input name='id_user_found' id='id_user_found' hidden value=\"" . $_SESSION['userId'] . "\"/>";
                } ?>
                <input type='text' name='id_pet_found' id='id_pet_found' value=' ' hidden>
                <select type="text" name="locatieFound" list="ZoneFound" placeholder="Found Location"  id='src_fnd'>
                <!-- <datalist id="ZoneFound"> -->
                    <option >Copou</option>
                    <option >Ticau</option>
                    <option >Zimbru</option>
                    <option >Sararie</option>
                    <option >Podu de fier</option>
                    <option >Agronomie</option>
                    <option >Targu cucului</option>
                    <option >Tudor vladimirescu</option>
                    <option >Bucsinescu</option>
                    <option >Tatarasi nord</option>
                    <option >Tatarasi sud</option>
                    <option >Moara de vant</option>
                    <option >Ciurchi</option>
                    <option >Metalurgie</option>
                    <option >Aviatiei</option>
                    <option >Zona industriala dancu</option>
                    <option >Baza 3</option>
                    <option >Bularga</option>
                    <option >Bucium</option>
                    <option >Socola</option>
                    <option >Frumoasa</option>
                    <option >Manta rosie</option>
                    <option >Podu ros</option>
                    <option >Dimitrie cantemir</option>
                    <option >Tesatura</option>
                    <option >Nicolina 1</option>
                    <option >Nicolina 2</option>
                    <option >Cug 1</option>
                    <option >Cug 2</option>
                    <option >Galata 1</option>
                    <option >Galata 2</option>
                    <option >Podu de piatra</option>
                    <option >Zona industriala sud</option>
                    <option >Mircea cel batran</option>
                    <option >Alexandru cel bun</option>
                    <option >Gara</option>
                    <option >Dacia</option>
                    <option >Pacurari</option>
                    <option >Canta</option>
                    <option >Pacuret</option>
                    <option >Moara de foc</option>
                    <option>Alta locatie</option>

                </select>

                </datalist>
                <input type="number" step="0.0000000000001" name="latFound" id='latFound' value='' hidden>
                <input type="number" step="0.0000000000001" name="lngFound" id='lngFound' value='' hidden>
                <input type="submit" name="submitFound" value="I HAVE FOUND THE PET" onclick="found()">
            </div>
        </div>

        <div class="hidden " id="change-pet">
            <div>
                <label for='inp-chn'>
                    <h3> Click on the map where you saw the pet</h3>
                </label>
                <input type='text' name='id_pet_change' id='id_pet_change' value='' hidden>
                <input type="number" step="0.0000000000001" name="latChange" id='latChange' value='' hidden>
                <input type="number" step="0.0000000000001" name="lngChange" id='lngChange' value='' hidden>
                <input type="submit" name="submitChange" id='inp-chn' onclick="changeLocation()">
            </div>
        </div>
        <!-- <a href="./" download="index.php"><button>Download</button></a> -->
        <div id="mapid"></div>
        <div id="maplost"></div>





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
        <div class="img-main">
            <img id="img-for-main" class="img-log" src="./img/Main for index.png"  alt="Image for main">
        </div>
    <?php

 }
 ?>


</main>

<?php

require 'footer.php';
?>