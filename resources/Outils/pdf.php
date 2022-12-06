<?php

define('PATH_ROOT', '../public');
require('fpdf185/fpdf.php');

use Modeles\PdoGsb;

//namespace Outils;

class pdf extends FPDF {

    function Header() {
        // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image(PATH_ROOT . '/images/logo.jpg', 8, 2);
        // Saut de ligne 20 mm
        $this->Ln(20);

        // Titre en gras avec une police Arial de 11
        $this->SetFont('Arial', 'B', 11);
        // fond gris
        $this->setFillColor(230, 230, 230);
        // position du coin supérieur gauche
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(60, 8, utf8_decode('état frais'), 0, 1, 'C', 1);
        // Saut de ligne 10 mm
        $this->Ln(10);
    }

// Load data
    function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(',', trim($line));
        }

        return $data;
    }

    function BasicTable($header, $data) {
        // Header
        foreach ($header as $col){
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col){
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
            // Titre en gras avec une police Arial de 11
            $this->SetFont('Arial', 'B', 11);
            // fond gris
            $this->setFillColor(230, 230, 230);
            // position du coin supérieur gauche
            $this->SetX(70);
            // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
            $this->Cell(60, 8, utf8_decode('état frais'), 0, 1, 'C', 1);
            // Saut de ligne 10 mm
            $this->Ln(10);
        }
    }

    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 9);
        // Numéro de page, centré (C)
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

$pdo = PdoGsb::getPdoGsb();
$idVisiteur = $_SESSION['idVisiteur'];
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
//ob_start();
ob_clean();
$pdf = new pdf();
$pdf->AddPage();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
$pdf->SetFont('Arial', '', 14);
// Data loading
//$data = $pdf->LoadData($pdo->getLesFraisForfait($idVisiteur, '202209'));
$i = 0;
$pablo = $pdo->getLesFraisForfait($idVisiteur, '202209');
$pdf->BasicTable($header, $pablo);
$pdf->Image('../resources/Outils/signatureComptable.jpg', 130, 240);
//ob_clean();
$pdf->Output();
//ob_end_flush();