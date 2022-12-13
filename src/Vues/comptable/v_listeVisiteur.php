<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>


<div class="row">
<form action="<?php echo $uc?>&action=selectionnerMois" method="post">
    <div class="col-md-4">
        <label>Visiteur :</label>
        <select id="lstVisiteur" name="lstVisiteur" class="form-control" onchange="this.form.submit()">
            <option value="" >choisir un visiteur..</option>

            <?php
            foreach($lesVisiteurs as $unVisiteur){
                $nom = $unVisiteur['nom'];
                $prenom = $unVisiteur['prenom'];
                $id = $unVisiteur['id'];
                if ($id == $idVisiteur){
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
    <!--</div>-->
</form>