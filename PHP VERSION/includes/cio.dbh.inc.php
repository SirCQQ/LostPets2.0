<?php
require 'upload.php';

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
    $fileName = substr(md5(uniqid(rand(1, 6))), 0, 8);
    return $fileName;
}

function getIdUser()
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

function getIdPet()
{
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

    return $id + 1;
}

function login($mail, $pwd)
{
    $conn = start();

    if ($conn) { }
    $sql = 'SELECT * FROM userinfo where email= :mail ';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':mail', $mail);
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    if ($row) {
        $pwdCheck = password_verify($pwd, $row['USER_PASSWORD']);
        if ($pwdCheck === false) {
            oci_free_statement($stid);
            oci_close($conn);
            $stat = array('status' => "Wrong Password");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
        } else if ($pwdCheck == true) {
            session_start();
            $_SESSION['userId'] = $row['USER_ID'];
            $_SESSION['userEmail'] = $row['EMAIL'];
            // header("Location: ../?login=success");
            $stat = array('status' => "success");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
        } else {
            oci_free_statement($stid);
            oci_close($conn);
            $stat = array('status' => "Somethink went wrong");
            header('Content-Type: application/json',);
            // echo json_encode($stat);
            exit();
        }
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        $stat = array('status' => "No User");
        header('Content-Type: application/json');
        echo json_encode($stat);
        exit();
    }
    oci_free_statement($stid);
    oci_close($conn);
}

function getpets()
{
    $pets = array();
    $conn = start();
    $sql = 'SELECT * FROM allpets where pet_status=\'lost\' ORDER BY pet_id desc ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $info = getDateDeContact($row['PET_ID']);
        $petInfo = array(
            'pet_id' => $row['PET_ID'],
            'pet_name' => $row['PET_NAME'],
            'pet_photo' => $row['POZA_IMG'],
            'pet_type' => $row['PET_TYPE'],
            'pet_details' => $row['PET_DETAILS'],
            'reward' => $row['REWARD'],
            'zona_pierdut'=>$row['ZONA_PIERDUT']
        );
        $pet = array('pet' => $petInfo, 'contact' => $info);
        array_push($pets, $pet);
    }
    oci_free_statement($stid);
    oci_close($conn);
    return json_encode($pets);
}

function getTableAnimals()
{
    $table = array();
    $conn = start();
    $sql = 'SELECT * FROM allpets where pet_status=\'lost\' ORDER BY pet_id desc ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $pet = array('pet_id' => $row['PET_ID'], 'lat_lost' => $row['LAT_LOST'], 'lng_lost' => $row['LON_LOST']);
        array_push($table, $pet);
    }
    return json_encode($table);
}

function register($name, $prenume, $nrTel, $email, $pass, $file)
{

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

function formular($nume, $animal, $detalii, $zona, $recompensa, $latLost, $lngLost, $userId, $file)
{

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

    oci_bind_by_name($stid, ':pet_status', $pet_status);

    $r = oci_execute($stid);  // executes and commits
    if ($r) {

        oci_free_statement($stid);
        oci_close($conn);
        addToUser($pet_id, $userId);
        zone($pet_id, $zona, $nume, 1);
        header("Location: ../index.php?addPetSuccessfully");
        exit();
    } else {
        oci_free_statement($stid);
        oci_close($conn);

        header("Location: ../index.php?addPetFail");
    }
}

function addToUser($pet_id, $userId)
{
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
    }
}

function found($pet_id, $user_id, $location_found, $lat_found, $lng_found)
{
    $conn = start();
    $date_found = date("d/m/Y");

    $sql = 'UPDATE allpets SET zona_gasite=:location_found, finder_id=:user_id,
     date_found=:date_found,lat_found=:lat_found,lon_found=:lon_found,pet_status=\'found\' WHERE pet_id=:pet_id ';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':location_found', $location_found);
    oci_bind_by_name($stid, ':user_id', $user_id);
    oci_bind_by_name($stid, ':date_found', $date_found);
    oci_bind_by_name($stid, ':lat_found', $lat_found);
    oci_bind_by_name($stid, ':lon_found', $lng_found);
    oci_bind_by_name($stid, 'pet_id', $pet_id);
    $r = oci_execute($stid);  // executes and commits
    if ($r) {
        oci_free_statement($stid);
        oci_close($conn);
       $stare=zone($pet_id, $location_found, getPetName($pet_id), 2);
       if($stare===1){ 
            $stat = array('status' => "Update Success");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
       }
       else
       {
        oci_free_statement($stid);
        oci_close($conn);
        $stat = array('status' => "Update Fail");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
       }
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        $stat = array('status' => "Update Fail");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
    }
}

function updateLocation($pet_id, $lat, $lon)
{
    $conn = start();

    // echo "i got the data";
    // echo $pet_id."\n".$lat."\n".$lon."\n";
    $sql = 'UPDATE allpets SET lat_lost=:lat,lon_lost=:lon WHERE pet_id=:pet_id';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':pet_id', $pet_id);
    oci_bind_by_name($stid, ':lat', $lat);
    oci_bind_by_name($stid, ':lon', $lon);
    $r = oci_execute($stid);  // executes and commits
    if ($r) {
        oci_free_statement($stid);
        oci_close($conn);
        $stat = array('status' => "Update Location Success");
            header('Content-Type: application/json');
            echo json_encode($stat);
            exit();
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        $stat = array('status' => "Fail to Change Location ");
            header('Content-Type: application/json');
            echo json_encode($stat);
            // exit();
    }
}

function getUserPhoto($userid)
{
    $conn = start();
    $stid = oci_parse($conn, 'SELECT profile_img FROM userinfo WHERE user_id=:userid');
    oci_bind_by_name($stid, ':userid', $userid);

    $r = oci_execute($stid);
    if ($r) {
        $pic = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        oci_free_statement($stid);
        oci_close($conn);
        // echo "///".$pic['PROFILE_IMG']."!!!";
        return $pic['PROFILE_IMG'];
        
    } else {
        return "BasicProfileImg";
    }
}

function zone($id_pet, $zona, $nume_animal, $case)
{
    $conn = start();
    $date = date("d/m/Y");
    $state='found';
    $sql1 = 'INSERT INTO notificari values(:id_pet,:zona,:nume,\'lost \',to_date(:date_n,\'DD/MM/YYYY\'))';
    $sql2 = "UPDATE  notificari set status_pet=:found where pet_id=:id_pet ";

    if ($case === 1) {
        incrementInteresZona($zona,2);
        $stid = oci_parse($conn, $sql1);
        oci_bind_by_name($stid, ':zona', $zona);
        oci_bind_by_name($stid, ':nume', $nume_animal);
        oci_bind_by_name($stid, ':date_n', $date);
    } else {
        if ($case === 2) {
            incrementInteresZona($zona,1);
            $stid = oci_parse($conn, $sql2);
            oci_bind_by_name($stid, ':found', $state);
        }
    }
    
    oci_bind_by_name($stid, ':id_pet', $id_pet);
    
    $r = oci_execute($stid);
    if ($r) {
        oci_free_statement($stid);
        oci_close($conn);
        return 1;
    } else {
        oci_free_statement($stid);
        oci_close($conn);
        return -1;
    }
}

function getPetName($pet_id)
{
    $conn = start();
    $stid = oci_parse($conn, 'SELECT Pet_name FROM allpets WHERE pet_id=:pet_id');
    oci_bind_by_name($stid, ':pet_id', $pet_id);
    $r = oci_execute($stid);
    if ($r) {
        $pic = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        oci_free_statement($stid);
        oci_close($conn);
        return $pic['PET_NAME'];
    }
}

function getNotifications()
{
    $notifications = array();
    $conn = start();
    $sql = 'SELECT * FROM notificari WHERE STATUS_PET=\'lost \' ORDER BY data_anunt desc ';
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $not = array('pet_name' => $row['NUME_ANIMAL'], 'zona' => $row['NUME_ZONA'],'pet_id'=>$row['PET_ID']);
        array_push($notifications, $not);
    }
    oci_free_statement($stid);
    oci_close($conn);
    return json_encode($notifications);
}

function getDateDeContact($id_pet)
{
    $conn = start();
    $stid = oci_parse($conn, 'SELECT email , nrtelefon  FROM  userinfo  u
     join USER_PET up on u.user_id=up.user_id join allpets a on a.pet_id=up.pet_id where a.Pet_id=:id_pet ');
    oci_bind_by_name($stid, ':id_pet', $id_pet);
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $id = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
    oci_free_statement($stid);
    oci_close($conn);

    $contact = array('nrTel' => $id["NRTELEFON"], 'email' =>  $id['EMAIL']);
    return $contact;
}
function incrementInteresZona($zone,$case){
    $conn=start();
    $sql="SELECT * FROM ZoneDeInteres
     WHERE nume_zona=:zona
     ";
    $stid=oci_parse($conn,$sql);
    oci_bind_by_name($stid,':zona',$zone);
    $r=oci_execute($stid);
    if(!$r){
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
    // print_r($row);
    $lostAnimals=$row["ANIMALE_DISPARUTE"];
    $findAnimals=$row["ANIMALE_GASITE"];
    $lostAnimals=$lostAnimals;
    // echo $lostAnimals."   ".$findAnimals;
    oci_free_statement($stid);
    if($case===1){
    $sql = "UPDATE ZoneDeInteres SET animale_gasite=:animale_gasite WHERE nume_zona=:zona";
    $stid=oci_parse($conn,$sql);
    $findAnimals=$findAnimals+1;
    oci_bind_by_name($stid,':zona',$zone);
    oci_bind_by_name($stid,':animale_gasite',$findAnimals);
    $r1=oci_execute($stid);
    }
    if($case===2){
    $sql = "UPDATE ZoneDeInteres SET animale_disparute=:animale_pierdute WHERE nume_zona=:zona";
    $stid=oci_parse($conn,$sql);
    $lostAnimals=$lostAnimals+1;
    oci_bind_by_name($stid,':zona',$zone);
    oci_bind_by_name($stid,':animale_pierdute',$lostAnimals);
    $r2=oci_execute($stid);
    }
    oci_free_statement($stid);
    oci_close($conn);
}

function createCSV($data)
{
    $table = json_decode($data, true);
    $myfile = fopen("./Files/Statistici.csv", "r+") or die("Unable to open file!");
    // echo "Am deschis fisierul";
    file_put_contents("./Files/Statistici.csv",''); 
    $txt = "Nume zona,Animale pierdute, Animale gasite \n";
    fwrite($myfile, $txt);
    $maxLost = 0;
    $maxFound = 0;
    $cartierPierdute = array();
    $cartierGasite = array();
    foreach ($table as $row) {
        $txt = $row[0] . ',' . $row[1] . ',' . $row[2] . " \n";
        fwrite($myfile, $txt);
        // echo $txt."\n";

        if ($row[1] == $maxLost) {
            array_push($cartierPierdute, $row[0]);
            // $row[0] ;  
        } else {
            if ($row[1] > $maxLost) {
                $maxLost = $row[1];
           
                $cartierPierdute = array();
                array_push($cartierPierdute, $row[0]);
                // $row[0];
            }
        }
        if ($row[2] == $maxFound) {
            array_push($cartierGasite, $row[0]);
        } else {
            if ($row[2] > $maxFound) {
                $maxFound = $row[2];
                $cartierGasite = array();

                array_push($cartierGasite, $row[0]);
                // $row[0];
            }
        }
    }


    if ($maxLost > 0) {
        fwrite($myfile, "Cele mai multe animale sunt pierdute in: ");
        $txt = '';
        foreach ($cartierPierdute as $cartier) {
            if ($txt == '') {
                $txt = $txt . $cartier;
            } else {
                $txt = $txt . ',' . $cartier;
            }
        }
        $txt = $txt . "\n";
        fwrite($myfile, $txt);
    }


    if ($maxFound > 0) {
        fwrite($myfile, "Cele mai multe animale sunt gasite in: ");
        $txt = '';
        foreach ($cartierGasite as $cartier) {
            if ($txt == '') {
                $txt = $txt . $cartier;
            } else {
                $txt = $txt . ',' . $cartier;
            }
        }
        $txt = $txt . "\n";
        fwrite($myfile, $txt);
    }


    fclose($myfile);
}

function getZoneInfo(){
    $conn=start();
    $zone=array();
    $sql="SELECT * FROM ZoneDeInteres ORDER BY nume_zona ASC";
    $stid=oci_parse($conn,$sql);
    $r=oci_execute($stid);
   
    while($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
        // $zona=array(
        //     'nume_zona'=>$row["NUME_ZONA"]
        //     ,'animale_disparute'=>$row['ANIMALE_DISPARUTE']
        //     ,'animale_gasite'=>$row['ANIMALE_GASITE']
        // );
        $zona=array();
        array_push($zona,$row["NUME_ZONA"]);
        array_push($zona,$row["ANIMALE_DISPARUTE"]);
        array_push($zona,$row["ANIMALE_GASITE"]);
        array_push($zone,$zona);
    }
    oci_free_statement($stid);
    oci_close($conn);

    return json_encode($zone);
}


// require ('../FPDF/fpdf.php');
