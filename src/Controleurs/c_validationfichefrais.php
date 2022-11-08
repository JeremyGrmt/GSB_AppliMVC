<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

use Outils\Utilitaires;

$idVisiteur = $_SESSION['idVisiteur'];
$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//echo($action);
switch ($action) {
    case 'selectionnerVisiteur':
        $lesVisiteurs = $pdo->getInfosLesVisiteurs();
        $Cles = array_keys($lesVisiteurs);
        $visiteurASelectionner = $Cles[0];
        include PATH_VIEWS . 'v_listeVisiteur.php';
        break;
    case 'selectionnerMois':
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        break;
//    case 'saisirFrais':
//        if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
//            $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
//        }
//        break;
//    case 'validerMajFraisForfait':
//        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
//        if (Utilitaires::lesQteFraisValides($lesFrais)) {
//            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
//        } else {
//            Utilitaires::ajouterErreur('Les valeurs des frais doivent être numériques');
//            include PATH_VIEWS . 'v_erreurs.php';
//        }
//        break;
//    case 'validerCreationFrais':
//        $dateFrais = Utilitaires::dateAnglaisVersFrancais(
//            filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
//        );
//        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
//        Utilitaires::valideInfosFrais($dateFrais, $libelle, $montant);
//        if (Utilitaires::nbErreurs() != 0) {
//            include PATH_VIEWS . 'v_erreurs.php';
//        } else {
//            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $dateFrais, $montant);
//        }
//        break;
//    case 'supprimerFrais':
//        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        $pdo->supprimerFraisHorsForfait($idFrais);
//        break;
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
require PATH_VIEWS . 'v_valideFicheFrais.php';
//require PATH_VIEWS . 'v_listeFraisHorsForfait.php';