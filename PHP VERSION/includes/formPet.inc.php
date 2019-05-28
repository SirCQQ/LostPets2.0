<?php 
    require 'cio.dbh.inc.php';
    if(isset($_POST['pet-submit']))
    {   
        if(isset($_FILES['prfImg'])){
            $file=$_FILES['prfImg'];
            
            // print_r($_FILES['prfImg']);
        }
        else {
           
            // print_r($_FILES['prfImg']);
            echo "NO FILE!!!";
        }
        $userId= $_POST['userId'];
        $petName=$_POST['name'];
        $animal=$_POST['animal'];
        $detalii=$_POST['detalii'];
        $zona=$_POST['zona'];
        $recompensa=$_POST['recompensa'];
        $latLost=$_POST['latLostForm'];
        $lngLost=$_POST['lngLostForm'];

        echo 'pet name: '.$petName.'  type: '.$animal.' detalii: '.$detalii.' zona: '.$zona.'  recompensa: '.$recompensa.' lat: '.$latLost.' lng: '.$lngLost;
        echo "\n userId : ".$userId;
        if(empty($petName) ||empty($animal) ||empty($detalii) ||empty($zona) ||empty($recompensa) ||empty($latLost) ||empty($lngLost) )
        {
            // schimba cu header loction 
            echo "not all fields are filed";
        }
        else {
            formular($petName,$animal,$detalii,$zona,$recompensa,$latLost,$lngLost,$userId,$file);
        }
    }
    else {
        header("Location: ../index.php");
        exit();
    }
