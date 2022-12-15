<?php

/**
 * Gestion de la connexion
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

use Outils\Utilitaires;

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$uc) {
    $uc = 'demandeconnexion';
}

$ip = $_SERVER['REMOTE_ADDR'];
$iplist = $pdo->getIpList();
if (!in_array($ip,$iplist)){
    $pdo->ajouteIp($ip);
}

switch ($action) {
    case 'demandeConnexion':
        include PATH_VIEWS . 'v_connexion.php';
        break;
    case 'valideConnexion':
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $utilisateur = $pdo->getInfosUtilisateur($login);
        if (!password_verify($mdp,$pdo->getMdpUtilisateur($login)) && !Utilitaires::journaliserNbEchec($nbEchec)) {
            Utilitaires::ajouterErreur('Login ou mot de passe incorrect');
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS . 'v_connexion.php';
        }elseif (Utilitaires::journaliserNbEchec($nbEchec)){
            $ip = $_SERVER['REMOTE_ADDR'];
            $heureActuelle = new \DateTime();
            $tempsRestant = (int)strtotime($pdo->recupDateBlocage($ip))+3600 - (int)strtotime($heureActuelle);
            Utilitaires::ajouterErreur("Nombre de tentatives de connexions dépassées. L'administration à été prévenue." . $tempsRestant . 'min');
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS . "v_blocage.php";
        } else {
            $id = $utilisateur['id'];
            $nom = $utilisateur['nom'];
            $prenom = $utilisateur['prenom'];
            $role = $utilisateur['role'];
            Utilitaires::connecter($id, $nom, $prenom,$role);
            $email = $utilisateur['email'];
            $code = rand(1000,2000);
            // code temporaire histoire de pouvoir faire de l'automatisation :
            $code = 1234;
            $pdo->setCodeA2F($id,$code);
            mail($email,'[GSB-AppliFrais] Code de vérification', "Code : $code");
            include PATH_VIEWS . 'v_code2facteurs.php';
        }
        break;
    case 'valideA2FConnexion':
        $code = filter_input(INPUT_POST,'code',FILTER_SANITIZE_NUMBER_INT);
        if ($pdo->getCodeUtilisateur($_SESSION['idVisiteur'])!==$code){
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS . 'v_code2facteurs.php';
        } else{
            Utilitaires::connecterA2F($code);
            header('Location: index.php');
        }
        break;
    case 'bloque':
        $heureActuelle = new \DateTime();
        if ($heureActuelle<(int)strtotime($pdo->recupDateBlocage($ip))+3600){
            include PATH_VIEWS . 'v_blocage.php';
        }
        else{
            include PATH_VIEWS . 'v_connexion.php';
        }
        break;
    default:
        include PATH_VIEWS . 'v_connexion.php';
        break;
}
