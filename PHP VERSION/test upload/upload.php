
<?php
$fileNewName="hahaha";
if (isset($_POST['submit'])){
         $file= $_FILES['file'];

upload_photo($file,$fileNewName);
}
else {
    echo 'fail';
}

function upload_photo($file,$fileNewName){  
// if (isset($_POST['submit'])){
//     $file= $_FILES['file'];
//     print_r ($file);
if(isset($file)){
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];
    // echo $fileType;
    // print_r($file);
    if($file['name']!==''){
    echo "    asta e  numele ".$file['name']." si aici se termina";
    }
    else 
    echo"Numele este nesetat"; 
    
    // $fileExt=explode('.',$fileName);
    //     $fileActualExt=strtolower(end($fileExt));

    //     $allowed= array('jpg','jpeg','png');  
    //     if(in_array($fileActualExt,$allowed)){
    //         if($fileError===0)
    //         {
    //             if($fileSize<100000)
    //             {
                    
    //                 echo $fileNewName;
    //                 $fileDestination="../uploads/".$fileNewName.'.'.$fileActualExt;
    //                 move_uploaded_file($fileTmpName,$fileDestination);
    //                 header("Location: index.php?uploadsuccess");
    //             } 
    //             else {
    //                 echo "The file is too big!";
    //             }

    //         }
    //         else {
    //             echo "There was an error uploading our file!";
    //         }


    //     }
    //     else {
    //         echo "You can not upload this type of file!";
    //     }

}

}
?>
