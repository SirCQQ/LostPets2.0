<?php



function start()
{
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $bDName = "lostpets";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $bDName);

    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }
    else{
        // echo "Connect to database";
        return $conn;
    }

}


function register($name, $prenume, $nrTel, $email, $pass)
{
    $conn=start();
    $sql = "SELECT email FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($conn);
  
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerrortoconnect");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if ($resultCheck > 0) {
            header("Location: ../index.php?error=emailexists&nume=" . $name . "&prenume=" . $prenume . "&numertelefon" . $nrTel);
            exit();
        } else {
            $sql = "INSERT INTO users (name,prenume,email,nrtelefon,user_password ) VALUES (?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../?error=sqlerror");
                exit();
            } else {
                $hasedPwd = password_hash($pass, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "sssss", $name, $prenume, $email, $nrTel, $hasedPwd);
                mysqli_stmt_execute($stmt);
                header("Location: ../?signup=success");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}



function login($mail, $pwd)
{
    $conn=start();
    $sql = "SELECT * FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
         header("Location: ../?error=sqlerrorconnecting");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $mail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            echo $pwd;
            $pwdCheck = password_verify($pwd, $row['user_password']);
            if ($pwdCheck == false) {
                 header("Location: ../?error=wrongpwd");
                exit();
            } else if ($pwdCheck == true) {
                session_start();
                $_SESSION['userId'] = $row['user_id'];
                $_SESSION['userEmail'] = $row['email'];

                 header("Location: ../?login=success");
                exit();
            } else {
                 header("Location: ../?error=SOMETHINKELSE");
                exit();
            }
        } else {
             header("Location: ../?error=nouser");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
