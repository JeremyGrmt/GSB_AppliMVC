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

switch ($action) {
    case 'demandeConnexion':
        include PATH_VIEWS . 'v_connexion.php';
        break;
    case 'valideConnexion':
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $utilisateur = $pdo->getInfosUtilisateur($login);
        if (!password_verify($mdp,$pdo->getMdpUtilisateur($login))) {
            Utilitaires::ajouterErreur('Login ou mot de passe incorrect');
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS . 'v_connexion.php';
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
    default:
        include PATH_VIEWS . 'v_connexion.php';
        break;
}
