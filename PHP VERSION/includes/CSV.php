<?php 
require "cio.dbh.inc.php";
function CSV(){
$data=getZoneInfo();
createCSV($data);
}
CSV();