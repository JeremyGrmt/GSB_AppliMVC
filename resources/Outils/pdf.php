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
        $this->SetFont('Arial', 'B', 20);
        // fond gris
        //$this->setFillColor(230, 230, 230);
        // position du coin supérieur gauche
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(60, 8, utf8_decode('état de frais engagé'), 0, 1, 'C', 0);
        // Saut de ligne 10 mm
        $this->SetFont( "Arial", "BU", 15 );
        $this->SetXY( 8, 50 ) ;
        $this->Cell($this->GetStringWidth("Visiteur"), 0, "Visiteur :", 0, "L");
        $this->Ln(20);
    }

    function BasicTable($header,$data) {
        // Header
        foreach ($header as $col)
            $this->Cell(45, 8, $col, 0, 0, 'C', 0);
        $this->Ln();
        // Données
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(45, 8, utf8_decode($col), 1);
            $this->Ln();
        }
    }

    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 9);
        // Numéro de page, centré (C)
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/1', 0, 0, 'C');
    }

}

$pdo = PdoGsb::getPdoGsb();
$idVisiteur = $_SESSION['idVisiteur'];
$lemois = $_SESSION['lemois'];
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$tablo = $pdo->getLesFraisForfait($idVisiteur, $lemois);
$lesMontant = $pdo->getMontantFraisForfait();
//ob_start();
ob_clean();
$pdf = new pdf();
$pdf->AddPage();
// Column headings
$libelleQuantite = array();
$header = array("Frais Forfais"
    , "Quantite"
    , "Montant Unitaire"
    ,"Total"
    );
$datasTablo = array();

$pdf->SetFont('Arial', '', 14);
// Data loading
//$data = $pdf->LoadData($pdo->getLesFraisForfait($idVisiteur, '202209'));
$i = 0;
foreach ($tablo as $unFrais) {
    $libelle = $unFrais['libelle'];
    $quantite = $unFrais['quantite'];
    array_push($libelleQuantite, $libelle);
    array_push($libelleQuantite, $quantite);
//faire une methode pour multiplier montant unitaire * $quantite
    array_push($datasTablo, $libelleQuantite);
    $libelleQuantite = array();
}
foreach ($lesMontant as $unFrais) {
    $montant = $unFrais['montant'];
    $total = floatval($datasTablo[$i][1])* floatval($montant);
    array_push($datasTablo[$i], $montant);
    array_push($datasTablo[$i],$total);
    $i++;
}
//array_push($header,$lemois);

$pdf->BasicTable($header,$datasTablo);
//$pdf->BasicTable($montants);
$pdf->Image('../resources/Outils/signatureComptable.jpg', 130, 240);
//ob_clean();
$pdf->Output();
//ob_end_flush();