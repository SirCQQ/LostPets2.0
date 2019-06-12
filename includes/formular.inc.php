<?php
if(isset($_POST['formular-submit'])){

    require 'dbh.inc.php';

    $nume = $_POST['name'];
    $tip = $_POST['animal'];
    $detalii = $_POST['detalii'];
    $zona = $_POST['zona'];
    $recompensa = $_POST['recompensa'];
    $image = $_POST['img'];

     if(empty($nume) || empty($tip)|| empty($zona)){
           header("Location: formular.html?error=emptyfields&name=".$nume."&animal=".$tip."&zona=".$zona);
           exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$nume) && !preg_match("/^[a-zA-Z]*$/",$tip)){
        header("Location: formular.html?error=invalidnameanimal&zona=".$zona);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$nume) && !preg_match("/^[a-zA-Z]*$/",$zona)){
        header("Location: formular.html?error=invalidnamezona&animal=".$tip);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$tip) && !preg_match("/^[a-zA-Z]*$/",$zona)){
        header("Location: formular.html?error=invalidanimalzona&name=".$nume);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$nume)){
        header("Location: formular.html?error=invalidname&animal=".$tip."&zona=".$zona);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$tip)){
        header("Location: formular.html?error=invalidanimal&name=".$nume."&zona=".$zona);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$zona)){
        header("Location: formular.html?error=invalidzonas&name=".$nume."&animal=".$tip);
        exit();

    }
    else{
         $sql= "INSERT INTO Pets (Pet_Name,Pet_Type,Pet_Details,Nume_Zona_Lost,Recompensa,Poza_Pet) VALUES ($nume, $tip, $detalii, $zona, $recompensa, $image)";
         if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
     }
     mysqli_close($conn);

}