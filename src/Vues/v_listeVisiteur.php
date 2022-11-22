<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

<h5>Choisir le visiteur</h5>
<form action="index.php?uc=validFicheFrais&action=selectionnerMois" method="post">
    <div class="form-group">
        <!--<label for="lstVisiteur" accesskey="n">Visiteur :</label>-->
        <select id="lstVisiteur" name="lstVisiteur" class="form-control" onchange="this.form.submit()">
            <option value="" >choisir un visiteur..</option>
            <?php
            foreach($lesVisiteurs as $unVisiteur){
                $nom = $unVisiteur['nom'];
                $prenom = $unVisiteur['prenom'];
                $id = $unVisiteur['id'];
                if ($id == $visiteurASelectionner){
                    ?>
                    <option selected value="<?php echo $id ?>">
                <?php echo $prenom . ' ' . $nom?> </option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $id ?>">
                    <?php echo $prenom . ' ' . $nom ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
</form>