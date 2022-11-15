<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>

<div>
    <form action="?uc=validFicheFrais&action=selectionnerVisiteur" method="post">
        <div class="form-group">
        <label>Choisir le visiteur : </label> 
        
        <select id="lstVisiteur" name="lstVisiteur" class="form-control">     
            <?php
        
        foreach ($lesVisiteurs as $unVisiteur){
            $nom = $unVisiteur['nom'];
            $prenom = $unVisiteur['prenom'];
            $id = $unVisiteur['id'];
            
            if ($id == $idASelectionner) {
                            ?>
                            <option value="//<?php echo $nom . ''. $prenom ?>">
                                //<?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="//<?php echo $nom . ''. $prenom  ?>">
                                //<?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
            
        }
        ?>
                            
        </select>
        <input type="submit" value="Subscribe!">
        </div>
        <?php
        include PATH_VIEWS . 'comptable\v_listeMois.php';
        ?>
                <!--        <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    //<?php
//                    foreach ($lesMois as $unMois) {
//                        $mois = $unMois['mois'];
//                        $numAnnee = $unMois['numAnnee'];
//                        $numMois = $unMois['numMois'];
//                        if ($mois == $moisASelectionner) {
//                            ?>
                            <option selected value="//<?php echo $mois ?>">
                                //<?php echo $numMois . '/' . $numAnnee ?> </option>
                            //<?php
//                        } else {
//                            ?>
                            <option value="//<?php echo $mois ?>">
                                //<?php echo $numMois . '/' . $numAnnee ?> </option>
                            //<?php
//                        }
//                    }
//                    ?>    

                </select>
            </div>-->
                
    </form>
</div>

<div class="row">    
    <h2>valider la fiche de frais</h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=gererFrais&action=validerMajFraisForfait" 
              role="form">
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Ajouter</button>
                <button class="btn btn-danger" type="reset">Effacer</button>
            </fieldset>
        </form>
    </div>
</div>