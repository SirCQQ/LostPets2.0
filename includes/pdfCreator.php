<?php 
require "oci.dbh.inc.php";
require "PDF.php";
$pdf=new PDF();

$pdf->AddPage();
$pdf->createPDF();
$pdf->Output();