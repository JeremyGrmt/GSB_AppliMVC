<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

define('PATH_ROOT','../../public');
require('fpdf185/fpdf.php');
use Modeles\PdoGsb;

class pdf extends FPDF
{
    
   
function Header() {
    // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
    $this->Image(PATH_ROOT.'/images/logo.jpg',8,2);
    // Saut de ligne 20 mm
    $this->Ln(20);

    // Titre en gras avec une police Arial de 11
    $this->SetFont('Arial','B',11);
    // fond gris
    $this->setFillColor(230,230,230);
     // position du coin supérieur gauche
    $this->SetX(70);
    // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
    $this->Cell (60,8,utf8_decode('état frais'),0,1,'C',1);
    // Saut de ligne 10 mm
    $this->Ln(10);    
}
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(',',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,$row[2],'LR',0,'R');
        $this->Cell($w[3],6,$row[3],'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

function Footer() {
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',9);
    // Numéro de page, centré (C)
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }
}

$pdf = new pdf();
$pdo = PdoGsb::getPdoGsb();
$idVisiteur = $_SESSION['idVisiteur'];
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
// Data loading
//$data = $pdf->LoadData($pdo->getLesFraisForfait($idVisiteur, '202209'));
$i=0;
$pablo = $pdo->getLesFraisForfait($idVisiteur, '202209');
while($i<count($pablo))
{
    $pdf->Cell(5, 5, $pablo[$i]);
    $i++;
}   
$pdf->Image('signatureComptable.jpg',130,240);
$pdf->Output('test.pdf');
