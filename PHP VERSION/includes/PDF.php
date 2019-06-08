<?php
require('fpdf.php');
class PDF extends FPDF
{
    // function __construct()
    //    {
    //       parent::FPDF();
    //    }
    function createPDF()
    {

        $header = array(
            'Numele Zonei',
            'Numarul de animale pierdute',
            'Numarul de animale gasite '
        );
        $data = getZoneInfo();
        // echo $data;
        $data = json_decode($data, true);
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', '', 14);
        // Header
        $w = array(55, 70, 65);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach ($data as $row) {
            // $this->Cell($w[0], 6, $row['nume_zona'], 'LR', 0, 'L', $fill);
            // $this->Cell($w[1], 6, $row['animale_disparute'], 'LR', 0, 'L', $fill);
            // $this->Cell($w[2], 6, $row['animale_gasite'], 'LR', 0, 'R', $fill);
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}