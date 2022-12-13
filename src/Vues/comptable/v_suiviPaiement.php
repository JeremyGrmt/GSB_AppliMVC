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
                               class="input-table-final"
                               disabled>
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
                    <td><input class="input-table-final" type="text" id="date" name="date" required value= <?php echo '"'.$date. '"' ?> disabled="disabled"></input></td>
                        <td><input class="input-table-final" type="text" id="libelle" name="libelle" required value= <?php echo '"'.$libelle. '"' ?> disabled="disabled"></td>
                        <td><input class="input-table-final" type="text" id="montant" name="montant" required value= <?php echo '"'.$montant. '"'  ?> disabled="disabled"></td>
                    </form>
                    
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>

<!--affichage des justificatifs-->
<div class="row">
    <form action="index.php?uc=suiviPaiement&action=miseEnPaiement">
        <div>
            <label>Nombre de justificatifs : </label>
            <input class="input-justif-final" type="text" id="nbJustificatifs" name="nbJustificatifs" required value= <?php echo '"'.$nbJustificatifs. '"'  ?> disabled="disabled">
        </div>
        <div class="btn-test">
            <button class="btn btn-success" type="submit">Mettre en paiement</button>
        <div>
    </form>
</div>

<div class="row">
    
</div>