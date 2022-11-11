<?php
$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais', 'userGsb', 'secret');
$pdo->query('SET CHARACTER SET utf8');

function augmentationNbCaractereMdp($pdo){
    $pdo->exec("ALTER TABLE utilisateur MODIFY mdp VARCHAR(255)");
    echo("le nombre de caractère de la colonne mdp est passé à 255\n");
}

function hashMdpVisiteur($pdo){
    $req = 'select * from utilisateur';
    $res = $pdo->query($req);
    $lesLignes = $res->fetchAll();
    foreach ($lesLignes as $unUtilisateur) {
        if (strlen($unUtilisateur['mdp'])<60){
            $mdp = password_hash($unUtilisateur['mdp'], PASSWORD_DEFAULT);
            $id = $unUtilisateur['id'];
            $req = "update utilisateur set mdp ='$mdp' where utilisateur.id ='$id' ";
            echo("le mdp de [".$unUtilisateur['prenom']." ".$unUtilisateur['nom']."] a été modifié en base\n");
            $pdo->exec($req);
        }
        else{ echo ("le mdp de [".$unUtilisateur['prenom']." ".$unUtilisateur['nom']."] n'a été modifié car il est déjà hashé\n");}
    }
}

augmentationNbCaractereMdp($pdo);
hashMdpVisiteur($pdo);