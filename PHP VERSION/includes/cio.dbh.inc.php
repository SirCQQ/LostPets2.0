<?php
require 'upload.php';

function start(){
    $username = 'LostPets';
    $password = 'parola';
    $connection_string = 'localhost/xe';
    $conn = oci_connect($username, $password, $connection_string);
    if ($conn) {
        return $conn;
    } else {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
}

function create_name(){
    $fileName = substr(md5(uniqid(rand(1, 6))), 0, 8);
    // echo $fileName;
    return $fileName;
}


function getIdUser(){
    $conn = start();
    $stid = oci_parse($conn, 'SELECT COUNT(*) FROM userinfo ');
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $id = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)['COUNT(*)'];
    oci_free_statement($stid);
    oci_close($conn);
    return $id + 1;
}

function getIdPet(){
    $conn = start();
    $stid = oci_parse($conn, 'SELECT COUNT(*) FROM allpets ');
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $id = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)['COUNT(*)'];
    oci_free_statement($stid);
    oci_close($conn);
    // echo $id;
    return $id + 1;
}



function login($mail, $pwd){
    $conn = start();

    if ($conn) {
        echo "conexiune buna \n";
    }
    // $mail="'".$mail."'";
    echo $mail;
    $sql = 'SELECT * FROM userinfo where email= :mail ';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':mail', $mail);
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    print_r($row);
    if ($row) {

        print_r($row);
        $pwdCheck = password_verify($pwd, $row['USER_PASSWORD']);
        if ($pwdCheck === false) {
            oci_free_statement($stid);
            oci_close($conn);
            header("Location: ../?error=wrongpwd");
            exit();
        } else if ($pwdCheck == true) {
            session_start();
            $_SESSION['userId'] = $row['USER_ID'];
            $_SESSION['userEmail'] = $row['EMAIL'];
            header("Location: ../?login=success");
            exit();
        } else {
            oci_free_statement($stid);
            oci_close($conn);
            header("Location: ../?error=SOMETHINKELSE");
            exit();
        }
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        header("Location: ../?error=nouser");
        exit();
    }
    oci_free_statement($stid);
    oci_close($conn);
}


function getpets(){

    $conn = start();
    $sql = 'SELECT * FROM allpets where pet_status=\'lost\' ORDER BY pet_id desc ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

        print " <div class='pet-card' id=\"" . $row['PET_ID'] . "\">
            <p class='name' pet_id=\"" . $row['PET_ID'] . "\" >Name:" . $row['PET_NAME'] .
            "</p>
            <img src='../PetPic/" . $row['POZA_IMG'] . "'  alt=''>
            
            <p class='pet-type' pet_id=\"" . $row['PET_ID'] . "\">Tip:" . $row["PET_TYPE"] .
            "
            <p class='pet-details' pet_id=\"" . $row['PET_ID'] . "\">Detalii:" . $row['PET_DETAILS'] . "</p>
            <p class='pet-zone' pet_id=\"" . $row['PET_ID'] . "\">Zona:" .
            $row['ZONA_PIERDUT'] . "</p>
            <p class='pet-reward' pet_id=\"" . $row['PET_ID'] . "\">Recompensa:" . $row['REWARD'] . "</p>
            <div class='buttons' pet_id=\"" . $row['PET_ID'] . "\">
            <button pet_id=\"" . $row['PET_ID'] . "\" onClick='changePet(".$row['PET_ID'].")'>Change Location</button>
            <button pet_id=\"" . $row['PET_ID'] . "\" onClick='foundPet(".$row['PET_ID'].")'>Found</button>
            </div>
            </div>";       
    }
    oci_free_statement($stid);
    oci_close($conn);
}

function getTable(){

    $conn = start();
    $sql = 'SELECT * FROM allpets where pet_status=\'lost\' ORDER BY pet_id desc ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
        echo "<table style='display:none'>";
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo "<tr pet-id>
        <td>".$row['PET_ID']."</td>
        <td>".$row['LAT_LOST']."</td>
        <td>".$row['LON_LOST']."</td>
        </tr>";
    }
echo "</table>";
}

function register($name, $prenume, $nrTel, $email, $pass, $file){

    $conn = start();
    $sql = 'INSERT INTO userinfo (user_id, nume,prenume,email,nrtelefon,user_password,profile_img) VALUES(:id,:nume,:prenume,:email,:nrtel,:parola,:img)';
    $stid = oci_parse($conn, $sql);
    $id = getIdUser();
    if ($file['name'] === '') {
        $img = '';
    } else {

        $img = create_name();

        upload_photo($file, $img, 1);
    }
    $fileName = $_FILES['prfImg']['name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $imgName = $img . '.' . $fileActualExt;
    $passR = password_hash($pass, PASSWORD_DEFAULT);
    oci_bind_by_name($stid, ':id', $id);
    oci_bind_by_name($stid, ':nume', $name);
    oci_bind_by_name($stid, ':prenume', $prenume);
    oci_bind_by_name($stid, ':email', $email);
    oci_bind_by_name($stid, ':nrtel', $nrTel);
    oci_bind_by_name($stid, ':parola', $passR);
    oci_bind_by_name($stid, ':img', $imgName);
    $r = oci_execute($stid);  // executes and commits
    if ($r) {
        oci_free_statement($stid);
        oci_close($conn);
        header("Location: ../index.php?createSuccess");
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        header("Location: ../index.php?createFail");
    }
}

function formular($nume, $animal, $detalii, $zona, $recompensa, $latLost, $lngLost, $userId, $file){

    $conn = start();
    $pet_id = getIdPet();
    $date_lost = date("d/m/Y");
    if ($file['name'] === '') {
        $img = '';
    } else {

        $img = create_name();
        upload_photo($file, $img, 2);
    }
    $pet_status = "lost";
    $sql = 'INSERT INTO allpets (
        Pet_Id,Pet_Name,pet_type,Poza_Img,zona_pierdut,reward,date_lost,pet_details,lat_lost,lon_lost,pet_status)
         VALUES(:id,:nume,:tip,:pet_img,:zona_pierdut,:reward,TO_DATE(:date_lost,\'DD/MM/YYYY\'),:pet_details,

         ' . $latLost . ',' . $lngLost . '
         ,:pet_status)';

    $fileName = $_FILES['prfImg']['name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $imgName = $img . '.' . $fileActualExt;
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':id', $pet_id);
    oci_bind_by_name($stid, ':nume', $nume);
    oci_bind_by_name($stid, ':tip', $animal);
    oci_bind_by_name($stid, ':pet_img', $imgName);
    oci_bind_by_name($stid, ':zona_pierdut', $zona);
    oci_bind_by_name($stid, ':reward', $recompensa);
    oci_bind_by_name($stid, ':date_lost', $date_lost);
    oci_bind_by_name($stid, ':pet_details', $detalii);
    // oci_bind_by_name($stid, ':lat_lost', $latLost);
    // oci_bind_by_name($stid, ':lon_lost', $lngLost);
    oci_bind_by_name($stid, ':pet_status', $pet_status);

    $r = oci_execute($stid);  // executes and commits
    if ($r) {
        // upload_photo($file, $img, 2);
        oci_free_statement($stid);
        oci_close($conn);
        addToUser($pet_id,$userId);
        header("Location: ../index.php?addPetSuccessfully");
        echo 'added in db';
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        echo "fail to add in db ";
        // header("Location: ../index.php?addPetFail");
    }
}

function addToUser($pet_id, $userId){
    $conn = start();
    $sql = "INSERT INTO user_pet values(:userId,:pet_id)";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':userId', $userId);
    oci_bind_by_name($stid, ':pet_id', $pet_id);
    $r = oci_execute($stid);  // executes and commits
    if ($r) {
        oci_free_statement($stid);
        oci_close($conn);
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        echo "<p>FAIL TO CONNECT USER TO PET</p>";
    }
}


// insert into allpets(pet_id,pet_name,pet_type,zona_pierdut,poza_img) values(4,'balteanu','caine','nicolina','hahaha');
