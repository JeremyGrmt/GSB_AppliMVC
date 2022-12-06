<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

<hr>
<!--affichage des frais forfait-->
<div class="row">    
    <h3>Suivi du paiement des frais : <?php echo $libEtat?></h3>
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
            </fieldset>
        </form>
    </div>
</div>

<!--affichage des frais hors forfait-->
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <form action="modifierdonnées" method="post">
                    <td><input class="input-table" type="text" id="date" name="date" required value= <?php echo '"'.$date. '"' ?>></input></td>
                        <td><input class="input-table" type="text" id="libelle" name="libelle" required value= <?php echo '"'.$libelle. '"' ?>></td>
                        <td><input class="input-table" type="text" id="montant" name="montant" required value= <?php echo '"'.$montant. '"'  ?>></td>
                        <td>
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <button class="btn btn-danger" type="reset">Réinitialiser</button>
                        </td> 
                    </form>
                    
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>
<div class="row">
    <form action="action"></form>
</div>