<?php
/**
 * Vue Liste des frais hors forfait
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
?>
<hr>
<!--<form method="post" role="form">-->
 <!--<form action="index.php?uc=validFicheFrais&action=validerMajFraisHorsForfait" method="post" role="form">-->
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
$i =0;
foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
    $date = $unFraisHorsForfait['date'];
    //$date = implode('-', array_reverse(explode('/', $unFraisHorsForfait['date'])));
    $montant = $unFraisHorsForfait['montant'];
    $id = $unFraisHorsForfait['id'];
    ?>           
                    <tr>       
                        <td><form id="form<?php echo $i ?>" action="index.php?uc=validFicheFrais&action=validerMajFraisHorsForfait&id=<?php echo  $id ?>" method="POST"><input class="input-table" type="string" id="date" name="date"  required value= <?php echo  '"' .  $date . '"'  ?>></form></td>
                        <td><input class="input-table" form="form<?php echo $i ?>" type="text" id="libelle" name="libelle" required value= <?php echo '"' . $libelle . '"' ?>></td>
                        <td><input class="input-table" form="form<?php echo $i ?>" type="text" id="montant" name="montant" required value= <?php echo '"' . $montant . '"' ?>></td>
                        <td>
                            <button class="btn btn-success" type="submit" form="form<?php echo $i ?>" formaction="index.php?uc=validFicheFrais&action=validerMajFraisHorsForfait&id=<?php echo  $id ?>">Corriger</button>
                            <button class="btn btn-danger" type="submit" form="form<?php echo $i ?>" formaction="index.php?uc=validFicheFrais&action=validerMajFraisHorsForfait&id=<?php echo  $id ?>&REFUS=REFUSE">refuser</button>
                        </td> 
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>  
        </table>

    </div>
</div>
          <!--</form>-->
<div class="row">
    <form action="action"></form>
</div>