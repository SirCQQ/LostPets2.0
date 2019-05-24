<?php

function start()
{
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

function create_name()
{
    $fileName = uniqid('', true);
    return $fileName;
}


function getId()
{
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

function register($name, $prenume, $nrTel, $email, $pass, $file)
{
    require 'upload.php';
    $conn = start();
    $stid = oci_parse($conn, 'INSERT INTO userinfo (user_id, nume,prenume,email,nrtelefon,user_password,profile_img) 
    VALUES(:id,:nume,:prenume,:email,:nrtel,:parola,:img)');
    $id = getId();
    if ($file['name'] === '') {
        $img = '';
    } else {

        $img = create_name();
        upload_photo($file, $img, 1);
    }
    $passR = password_hash($pass, PASSWORD_DEFAULT);
    oci_bind_by_name($stid, ':id', $id);
    oci_bind_by_name($stid, ':nume', $name);
    oci_bind_by_name($stid, ':prenume', $prenume);
    oci_bind_by_name($stid, ':email', $email);
    oci_bind_by_name($stid, ':nrtel', $nrTel);
    oci_bind_by_name($stid, ':parola', $passR);
    oci_bind_by_name($stid, ':img', $img);
    $r = oci_execute($stid);  // executes and commits
    upload_photo($file, $img, 1);
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


function login($mail, $pwd){
    $conn = start();

    if ($conn) {
        echo "conexiune buna \n";
    }
    // $mail="'".$mail."'";
    echo $mail;
    $sql = 'SELECT * FROM userinfo where email= :mail ';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid,':mail', $mail);
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


function getpets()
{

    $conn =start();
    $sql = 'SELECT * FROM allpets ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    // print "<table border='1'>\n";
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        // print "<tr>\n";
        // foreach ($row as $item) {
            // echo "heeey i a here ";
            print " <div class='pet-card' data-petId=   ".$row['PET_ID'].">
                <p class='name'>Name:".$row['PET_NAME'].
                "</p>
                     <img src='../Img/Main for index.png'  alt=''>
                
                     <p class='pet-type'>Tip:".$row["PET_TYPE"].
                     "
                    <p class='pet-details'>Detalii: Zgarda rosie cu medalion auriu pe care sunt date de contact</p>
                    <p class='pet-zone'>Zona:".
                    $row['ZONA_PIERDUT']."</p>
                         <p class='pet-reward'>Recompensa:".$row['REWARD']."</p>
                         <div class='buttons'>
                             <form action='#' method='post'>
                                 <input type='submit' value='Change Location'>
                             </form>
                             <form action='#' method='post'>
                                 <input type='submit' value='Found'>
                             </form>
                         </div>
                     </div>";
            // print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        // }
        // print "</tr>\n";
    }
    // print "</table>\n";
    oci_free_statement($stid);
    oci_close($conn);
}


function formular(){

}




// insert into allpets(pet_id,pet_name,pet_type,zona_pierdut,poza_img) values(4,'balteanu','caine','nicolina','hahaha');