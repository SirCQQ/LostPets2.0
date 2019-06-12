
<?php


function upload_photo($file,$fileNewName,$case){  
if(isset($file)){
    $fileName=$_FILES['prfImg']['name'];
    $fileTmpName=$_FILES['prfImg']['tmp_name'];
    $fileSize=$_FILES['prfImg']['size'];
    $fileError=$_FILES['prfImg']['error'];
    $fileType=$_FILES['prfImg']['type'];
    // echo $fileType;
    $fileExt=explode('.',$fileName);
        $fileActualExt=strtolower(end($fileExt));

        $allowed= array('jpg','jpeg','png');  
        if(in_array($fileActualExt,$allowed)){
            if($fileError===0)
            {
                if($fileSize<1000000)
                {
                    // $fileNewName="NewFile.".$fileActualExt;
                    // echo $fileNewName;
                    if($case===1){
                    $fileDestination="../ProfilePic/".$fileNewName.'.'.$fileActualExt;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    // header("Location: ../index.php?uploadsuccess");
                }
                    else if($case===2){
                        $fileDestination="../PetPic/".$fileNewName.'.'.$fileActualExt;
                        move_uploaded_file($fileTmpName,$fileDestination);
                        // header("Location: ../index.php?uploadsuccess");
                    }
                    else {
                    header("Location: ../index.php?uploadfail");
                    }
                    }
                    
                } 
                else {
                    echo "The file is too big!";
                }

            }
            else {
                echo "There was an error uploading our file!";
            }


        }
        else {
            echo "You can not upload this type of file!";
        }

}


?>
