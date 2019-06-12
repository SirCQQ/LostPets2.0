<?php 
require "oci.dbh.inc.php";
function CSV(){
$data=getZoneInfo();
createCSV($data);
}
CSV();