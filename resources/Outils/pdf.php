<?php
/**
 * Classe pour générer une fiche de frais en pdf.
 */
define('PATH_ROOT', '../public');
require('fpdf185/fpdf.php');

use Modeles\PdoGsb;
use Outils\Utilitaires;


class pdf extends FPDF {

    /**
     * fonction pour afficher le header du pdf avec le logo.
     */
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

    /**
     * 
     * @param array $header tableau du header déjà choisi.
     * @param array $data toutes les données à mettre dans le tableau à partir d'un tableau de tableaux.
     * @param array $tailleColonnes taille des colonnes prédéfinis pour éviter débordement.
     */
    function BasicTable(array $header, array $data, array $tailleColonnes) {
        // Header
        $i = 0;
        $this->setTextColor(0, 0, 230);
        $this->SetFont('Courier', 'I', 14);
        foreach ($header as $col){
            $this->Cell($tailleColonnes[$i], 8, utf8_decode($col), 0, 0, 'C', 0);
            $i++;
        }
        $this->Ln();
        $this->setTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 14);
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

    /**
     * Footer avec le numéro de la page.
     */
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
$idVisiteur = $_SESSION['idVisiteur']; //id du visiteur
$nomVisiteur = $_SESSION['nom']; //nom du visiteur
$prenomVisiteur = $_SESSION['prenom']; //prénom du visiteur
$lemois = $_SESSION['lemois']; //le mois  et l'année de la fiche de frais séléctionnée
$subMois = substr($lemois, 4, 6); //récup uniquement du mois
$subAnnee = substr($lemois, 0, 4); //récup uniquement de l'année
//$nomVisiteur = $pdo->getNomVisiteur($idVisiteur);
//$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$tablo = $pdo->getLesFraisForfait($idVisiteur, $lemois); //tableau des frais du visiteur et du mois séléctionnés
$lesMontant = $pdo->getMontantFraisForfait(); //obtenir le montant unitaire de chaque frais forfait
$lesMontantHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $lemois); //montant des frais hors forfait
$nbJustificatif = $pdo->getNbjustificatifs($idVisiteur, $lemois); //nb de justificatif
$totaltotal = 0;
//ob_start();
ob_clean();
$pdf = new pdf();
$pdf->SetTitle("Fiche Frais de ".$nomVisiteur . " ".$prenomVisiteur,True);
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
    50, 35, 55, 35
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
$montantPuissance = 1;
foreach ($lesMontant as $unFrais) {
    $montant = $unFrais['montant'];
//    if ($montantPuissance == 2){
//        $montant = Utilitaires::indemniteKilometrique($colonneNomPuissance);
//    }
    $total = floatval($datasTablo[$i][1]) * floatval($montant);
    array_push($datasTablo[$i], $montant);
    array_push($datasTablo[$i], $total);
    $i++;
    $montantPuissance++;
    $totaltotal += $total;
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
    $totaltotal += floatval($montant);
}
//array_push($header,$lemois);
$pdf->SetFont("Arial","", 14);
$pdf->SetXY(8, 60);
$pdf->Cell("Visiteur", 0, "Visiteur : ". utf8_decode($nomVisiteur) . " ". utf8_decode($prenomVisiteur), 0, "L");
$pdf->SetXY(8, 65);
$pdf->Cell("Mois", 0, "Fiche du : ". $subMois ."/".$subAnnee, 0, "L");
$pdf->SetXY(8, 70);
$pdf->Cell("Matricule", 0, "Matricule : ". $idVisiteur. "". utf8_decode($nomVisiteur), 0, "L");
$pdf->Ln(15);
$pdf->BasicTable($header, $datasTablo,$tailleColonnes1);
$pdf->setTextColor(0, 0, 0);
$pdf->Ln(10);
$pdf->Cell(180, 8, utf8_decode('Autres Frais'), 0, 1, 'C', 0);
$pdf->Ln(5);
$pdf->BasicTable($header2, $tabloHorsForfait,$tailleColonnes2);
$pdf->Ln(5);
$pdf->Cell("Justificatif", 0, "Nombre de justificatif : ". $nbJustificatif, 0, "L");
$pdf->Ln(10);
$pdf->SetX(105);
$pdf->Cell("Total ", 0, "Total de tous les frais : ". $totaltotal." euros", 0, "L");
$pdf->Ln(10);
$pdf->SetX(105);
$pdf->Cell("Fait ", 0, utf8_decode("Fait à Paris, le "). date('d '). date('F '). date('Y'), 0, "L");
$pdf->Ln(8);
$pdf->SetX(105);
$pdf->Cell("Vu ", 0, "Vu l'agent comptable", 0, "L");
$pdf->Ln(10);
//$pdf->BasicTable($montants);
$pdf->Image('../resources/Outils/signatureComptable.jpg',105);
//ob_clean();
$pdf->Output();
//ob_end_flush();