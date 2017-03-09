<div id="contenu">
	<div class="visiteur">
              
      <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
      <div class="corpsForm" class="visiteur">
      <h1>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee ?></h1>
      
            <h2>Eléments forfaitisés</h2>
            
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idFrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
					</p>
			
			<?php
				}
			?>
			     
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
       
      </form>
      
  