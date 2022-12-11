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
        $this->Ln(30);

        // Titre en gras avec une police Arial de 11
        $this->SetFont('Arial', 'B', 20);
        // fond gris
        //$this->setTextColor(0, 230, 0);
        // position du coin supérieur gauche
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(60, 8, utf8_decode('état de frais engagé'), 0, 1, 'C', 0);
        // Saut de ligne 10 mm
    }

    function BasicTable($header, $data, $tailleColonnes) {
        // Header
        $i = 0;
        foreach ($header as $col){
            $this->Cell($tailleColonnes[$i], 8, utf8_decode($col), 0, 0, 'C', 0);
            $i++;
        }
        $this->Ln();
        // Données
        //$verif = True;
        $j = 0;
        foreach ($data as $row) {
            //if ($verif){$this->setTextColor(0, 230, 0);}
            foreach ($row as $col){
                $this->Cell($tailleColonnes[$j], 8, utf8_decode($col), 1);
                $j++;
            }
            $j=0;
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
$nomVisiteur = $_SESSION['nom'];
$prenomVisiteur = $_SESSION['prenom'];
$lemois = $_SESSION['lemois'];
$subMois = substr($lemois, 4, 6);
$subAnnee = substr($lemois, 0, 4);
//$nomVisiteur = $pdo->getNomVisiteur($idVisiteur);
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$tablo = $pdo->getLesFraisForfait($idVisiteur, $lemois);
$lesMontant = $pdo->getMontantFraisForfait();
$lesMontantHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $lemois);
//ob_start();
ob_clean();
$pdf = new pdf();
$pdf->AddPage();
// Column headings
$libelleQuantite = array();
$header = array("Frais Forfais"
    , "Quantité"
    , "Montant Unitaire"
    , "Total"
    );
$header2 = array("Date"
    ,"Libellé"
    ,"Montant"
    );
$datasTablo = array();

$pdf->SetFont('Arial', '', 14);
// Data loading
//$data = $pdf->LoadData($pdo->getLesFraisForfait($idVisiteur, '202209'));
$i = 0;
//tailles des colonnes des tableaux
$tailleColonnes1 = array (
    45, 30, 45, 30
);
$tailleColonnes2 = array (
    45, 100, 30
);
foreach ($tablo as $unFrais) {
    $libelle = $unFrais['libelle'];
    $quantite = $unFrais['quantite'];
    array_push($libelleQuantite, $libelle);
    array_push($libelleQuantite, $quantite);
    array_push($datasTablo, $libelleQuantite);
    $libelleQuantite = array();
}
foreach ($lesMontant as $unFrais) {
    $montant = $unFrais['montant'];
    $total = floatval($datasTablo[$i][1]) * floatval($montant);
    array_push($datasTablo[$i], $montant);
    array_push($datasTablo[$i], $total);
    $i++;
}

//hors forfait
$tabloHorsForfait = array();
$tabloTemp = array();
foreach ($lesMontantHorsForfait as $unFraisHorsForfait) {
    $date = $unFraisHorsForfait['date'];
    $montant = $unFraisHorsForfait['montant'];
    $libelle = $unFraisHorsForfait['libelle'];
    array_push($tabloTemp, $date);
    array_push($tabloTemp, $libelle);
    array_push($tabloTemp, $montant);
    array_push($tabloHorsForfait, $tabloTemp);
    $tabloTemp = array();
}
//array_push($header,$lemois);
$pdf->SetFont("Arial","", 15);
$pdf->SetXY(8, 60);
$pdf->Cell("Visiteur", 0, "Visiteur : ". $nomVisiteur . " ". $prenomVisiteur, 0, "L");
$pdf->SetXY(8, 65);
$pdf->Cell("Mois", 0, "Fiche du : ". $subMois ."/".$subAnnee, 0, "L");
$pdf->Ln(20);
$pdf->BasicTable($header, $datasTablo,$tailleColonnes1);
$pdf->setTextColor(0, 0, 0);
$pdf->Ln(10);
$pdf->Cell(180, 8, utf8_decode('Autres Frais'), 0, 1, 'C', 0);
$pdf->Ln(10);
$pdf->BasicTable($header2, $tabloHorsForfait,$tailleColonnes2);
//$pdf->BasicTable($montants);
$pdf->Image('../resources/Outils/signatureComptable.jpg', 130, 240);
//ob_clean();
$pdf->Output();
//ob_end_flush();