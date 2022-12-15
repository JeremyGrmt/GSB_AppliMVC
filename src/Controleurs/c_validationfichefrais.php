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
    case 'selectionnerVisiteur':
        $lesVisiteurs = $pdo->getInfosLesVisiteurs();
        $Cles = array_keys($lesVisiteurs);
        $visiteurASelectionner = $Cles[0];
        include PATH_VIEWS . 'v_listeVisiteur.php';
        break;

    case 'selectionnerMois':
//        session_start();
        
        $uc = "index.php?uc=validFicheFrais";
        $uc_ac = "index.php?uc=validFicheFrais&action=validerfichefrais";
        
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
    case 'validerfichefrais':
        
        /*variable récupérant l'action*/
        $uc = "index.php?uc=validFicheFrais";

        $uc_ac = "index.php?uc=validFicheFrais&action=validerfichefrais";
        
        /*infos liste visiteurs*/
        $lesVisiteurs = $pdo->getInfosLesVisiteurs();
        $Cles = array_keys($lesVisiteurs);
        $idVisiteur = $_SESSION['sessionIdVisiteur']; //on recupere l'info partagée dans le premier formulaire
        
        /*infos liste mois*/
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
//        $lesCles = array_keys($lesMois);
        $moisASelectionner = $leMois;
        
        /*infos affichage fiches de frais*/
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        //gestion du cas où il n'y aurait pas de fiche de frais renvoyée
        if($lesInfosFicheFrais != false){
            //$numAnnee = substr($leMois, 0, 4);
            //$numMois = substr($leMois, 4, 2);
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = Utilitaires::dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
            $_SESSION['leMois'] = $leMois;
        }
        else{
            echo ('aucune fiche de frais enregistrée pour ce mois-ci.');
        }
        
        /*affichage vue*/
        include PATH_VIEWS . 'comptable\v_listeVisiteur.php';
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        include PATH_VIEWS . 'comptable\v_valideFicheFrais.php';
        include PATH_VIEWS . 'comptable\v_tableauHorsForfait.php';
        break;
//    case 'saisirFrais':
//        if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
//            $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
//        }
//        break;
    case 'validerMajFraisForfait':
       $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
       if (Utilitaires::lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        } else {
            Utilitaires::ajouterErreur('Les valeurs des frais doivent être numériques');
            include PATH_VIEWS . 'v_erreurs.php';
        }
        break;
    case 'validerMajFraisHorsForfait':

        $uc = "index.php?uc=validFicheFrais";
        $uc_ac = "index.php?uc=validFicheFrais&action=validerfichefrais";
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_DEFAULT);
        $date= filter_input(INPUT_POST, 'date', FILTER_DEFAULT);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_DEFAULT);
        //if (Utilitaires::lesQteFraisValides($lesFrais)) {
        if($_GET['REFUS'] != 'REFUSE'){
            $pdo->MajLigneFraisHorsForfait($_SESSION['sessionIdVisiteur'], $_SESSION['leMois'], $libelle,$date,$montant, $_GET['id']);
        }
        else{
            $pdo->MajLigneFraisHorsForfait($_SESSION['sessionIdVisiteur'], $_SESSION['leMois'], $libelle,$date,$montant, $_GET['id'], $_GET['REFUS']);
        }
            
            
            /*affichage vue*/
        include PATH_VIEWS . 'comptable\v_listeVisiteur.php';
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        include PATH_VIEWS . 'comptable\v_valideFicheFrais.php';
        include PATH_VIEWS . 'comptable\v_tableauHorsForfait.php';

            
       // } else {
            
//            Utilitaires::ajouterErreur('Les valeurs des frais doivent être numériques');
//            include PATH_VIEWS . 'v_erreurs.php';
//        }
        break;

    case 'refuserFraisHorsForfait':

        $uc = "index.php?uc=validFicheFrais";
        $uc_ac = "index.php?uc=validFicheFrais&action=validerfichefrais";
        $idFrais = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $pdo->refuserFraisHorsForfait($idFrais);
        break;
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
//require PATH_VIEWS . 'v_valideFicheFrais.php';
//require PATH_VIEWS . 'v_listeFraisHorsForfait.php';