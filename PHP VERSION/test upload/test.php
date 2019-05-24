<?php
$username = 'LostPets';
$password = 'parola';
$connection_string = 'localhost/xe';

$conn = oci_connect(
    $username,
    $password,
    $connection_string
);

if(!$conn){
$e = oci_error();
trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
else{ 

    $stid = oci_parse($conn, 'SELECT * FROM allpets');
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
// if (!$r) {
//     $e = oci_error($stid);
//     trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
// }
// print_r($r);
// print_r($row);
print "<table border='1'>\n";
// echo " intru in while ";
// print_r($row);
// print_r(oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS));
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    // print "<tr>\n";
    foreach ($row as $item) {
        // echo "heeey i a here ";
        print " <div class='pet-card'>
            <p class='name'>Name:".$row['PET_NAME'].
            "</p>
                 <img src='../Img/Main for index.png' style='height:100px' alt=''>
            
                 <p class='pet-type'>Tip:".$row["PET_TYPE"].
                 "
                <p class='pet-details'>Detalii: Zgarda rosie cu medalion auriu pe care sunt date de contact</p>
                <p class='pet-zone'>Zona:".
                $row['ZONA_PIERDUT']."</p>
                     <p class='pet-reward'>Recompensa: 300 de lei </p>
                     <div class='buttons'>
                         <form action='#' method='post'>
                             <input type='submit' value='Change Location'>
                         </form>
                         <form action='#' method='post'>
                             <input type='submit' value='Found'>
                         </form>
                     </div>
                 </div>";
        print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    // print "</tr>\n";
//     <div class='pet-card'>
//     <p class='name'>Name: Max</p>
//     <img src='../Img/Main for index.png' alt=''>

//     <p class='pet-type'>Tip: pisica </p>
//     <p class='pet-details'>Detalii: Zgarda rosie cu medalion auriu pe care sunt date de contact</p>
//     <p class='pet-zone'>Zona: Podul Ros</p>
//     <p class='pet-reward'>Recompensa: 300 de lei </p>
//     <div class='buttons'>
//         <form action='#' method='post'>
//             <input type='submit' value='Change Location'>
//         </form>
//         <form action='#' method='post'>
//             <input type='submit' value='Found'>
//         </form>
//     </div>
// </div>


}

print "</table>\n";

oci_free_statement($stid);


// $stid = oci_parse($conn, 'INSERT INTO userinfo (user_id, nume,prenume,email,age,nrtelefon,user_password,profile_img) 
// VALUES(:id,:nume,:prenume,:email,:age,:nrtel,:parola,:img)');

// $id = 7;
// $nume='Piuco';
// $prenume="Andrei";
// $email='andreipiuco@yahoo.com';
// $age=21;
// $nrtel='0751394925';
// $parola='haha2';
// $img='profileimg_6';

// oci_bind_by_name($stid, ':id', $id);
// oci_bind_by_name($stid, ':nume', $nume);
// oci_bind_by_name($stid, ':prenume', $prenume);
// oci_bind_by_name($stid, ':email', $email);
// oci_bind_by_name($stid, ':age', $age);
// oci_bind_by_name($stid, ':nrtel', $nrtel);
// oci_bind_by_name($stid, ':parola', $parola);

// $r = oci_execute($stid);  // executes and commits

// if ($r) {
//     print "One row inserted";
// }

oci_close($conn);
}
?>