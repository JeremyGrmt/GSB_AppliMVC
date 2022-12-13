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
switch ($action) {
    case 'selectionnerMois':
        $uc="index.php?uc=suiviPaiement";
        $uc_ac= "index.php?uc=suiviPaiement&action=afficheSuivi";
        $lesVisiteurs = $pdo->getInfosLesVisiteurs();
        
        $Cles = array_keys($lesVisiteurs);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['sessionIdVisiteur'] = $idVisiteur; //utilisation d'une session pour garder l'info entre les différent formulaires
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        //$lesCles = array_keys($lesMois);
        //$moisASelectionner = $lesCles[0];
        include PATH_VIEWS . 'comptable\v_listeVisiteur.php';
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        break;
    case 'afficheSuivi':
        /*variable récupérant l'action*/
        $uc_ac = "index.php?uc=suiviPaiement&action=afficheSuivi";
        
        /*infos liste visiteurs*/
        $lesVisiteurs = $pdo->getInfosLesVisiteurs();
        $Cles = array_keys($lesVisiteurs);
        $idVisiteur = $_SESSION['sessionIdVisiteur']; //on recupere l'info partagée dans le premier formulaire
        
        /*infos liste mois*/
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $moisASelectionner = $leMois;
        
        /*infos affichage fiches de frais*/
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        //gestion du cas où il n'y aurait pas de fiche de frais renvoyée
        if($lesInfosFicheFrais != false){
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = Utilitaires::dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        }
        else{
            echo ('aucune fiche de frais enregistrée pour ce mois-ci.');
        }
        
        /*affichage vue*/
        include PATH_VIEWS . 'comptable\v_listeVisiteur.php';
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        include PATH_VIEWS . 'comptable\v_suiviPaiement.php';
        break;
        
    case 'miseEnPaiement':
        $pdo->majEtatFicheFrais($idVisiteur,$leMois,"VA");
        break;
}