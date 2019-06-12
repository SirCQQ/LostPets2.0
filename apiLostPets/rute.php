<?php
require '../includes/oci.dbh.inc.php';
$endpoint =  $_SERVER['REQUEST_URI'];
$reqHeader = getallheaders();
$entityBody = file_get_contents('php://input');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (preg_match('/^\/api\/getAllPets$/', $endpoint)) {

            $data = getpets();
            header('Content-Type: application/json');
            echo $data;
            exit();
    }
    if (preg_match('/^\/api\/lostAnimals$/', $endpoint)) {

        $data = getTableAnimals();
        header('Content-Type: application/json');
        echo $data;
        exit();
}
if (preg_match('/^\/api\/notifications$/', $endpoint)) {

    $data = getNotifications();
    header('Content-Type:  application/json');
    echo $data;
    exit();
}
if (preg_match('/\/api\/userPhoto\/([0-9]+)$/', $endpoint,$matched)) {

        $data = getUserPhoto($matched[1]);
        echo $data;
        exit();
    }

    if (preg_match('/\/api\/getInfoZone$/', $endpoint,$matched)) {

        $data = getZoneInfo();
        header('Content-Type:  application/json');
        echo $data;
        exit();
    }

}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (preg_match('/^\/api\/login$/', $endpoint)) {

        $data=json_decode($entityBody,true);
        $email=$data['email'];
        $pass=$data['password'];
        login($email,$pass);
 
}
if (preg_match('/^\/api\/updateLocation$/', $endpoint)) {

    $data=json_decode($entityBody,true);
    $pet_id=$data['pet_id'];
    $lat=$data['lat'];
    $lon=$data['lng'];
    // echo $pet_id.'hahah';
    updateLocation($pet_id, $lat, $lon);
    // updateLocation(5,10, 10);

   
}
if (preg_match('/^\/api\/markAsFound$/', $endpoint)) {

    $data=json_decode($entityBody,true);
    $pet_id=$data['pet_id'];
    $user_id=$data['user_id'];
    $location_found=$data['location_found'];
    $lat_found=$data['lat_found'];
    $lng_found=$data['lng_found'];
    // print_r($data);
    // header('Content-Type: application/json');
    // echo $entityBody;
    found($pet_id,$user_id,$location_found,$lat_found,$lng_found);

}

}
else{
        header("Location: ../");
}