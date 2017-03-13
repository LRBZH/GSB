<form method="POST" action="index.php?uc=validerFicheFrais&action=majFraisForfait">
	<h2>Récapitulatif frais au forfait </h2>
	  	<table border="1">
	  	   
	        <tr>
	         <?php
	         foreach ( $lesFraisForfait as $unFraisForfait ) 
			 {
			 	
				$libelle = $unFraisForfait['libelle'];
			?>	
				<th> <?php echo $libelle?></th>
			 <?php
	        }
			?>
			</tr>
	        <tr for="idFrais">
	        <?php
	          foreach (  $lesFraisForfait as $unFraisForfait  ) 
			  {
			  		$idFrais = $unFraisForfait['idFrais'];
					$quantite = $unFraisForfait['quantite'];
			?>
	                <td class="qteForfait"><input disabled id="idFrais" class="inputSmall" name="lesFrais[<?php echo $idFrais?>]" value="<?php echo $quantite?>" ></input> </td>
			 <?php
	          }
			?>
				<td width="80"> 
					<select size="3" name="statut">
					<?php
						foreach ($lesEtats as $unEtat)
						{
						    $idEtat = $unEtat['id'];
							$libEtat =  $unEtat['libelle'];
							
						?>
							<option disabled value="<?php echo $unEtat ?>" <?php if ( $libEtat ==  $leLibEtat ) echo "selected"; ?> ><?php echo  $libEtat ?> </option>
						<?php 
						}

						?>
					</select></td>					
			</tr>   	
	    </table>
	    <br />
	  
		<h2>Récapitulatif frais hors-forfait</h2>   		
	  	<table border="1"> 	   
	             <tr>
	                <th class="date">Date</th>
	                <th class="libelle">Libellé</th>
	                <th class='montant'>Montant</th>                
	             </tr>
	        <?php      
	          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
			  {
			  	$id = $unFraisHorsForfait['id'];
				$date = $unFraisHorsForfait['date'];
				$libelle = $unFraisHorsForfait['libelle'];
				$montant = $unFraisHorsForfait['montant'];
			?>
	             <tr>
	                <td><input value="<?php echo $date ?>" disabled></input></td>
	                <td><input size="50" value="<?php echo $libelle ?>" disabled></input></td>
	                <td><input class="inputSmall" value="<?php echo $montant ?>" disabled></input></td>	                
	             </tr>
	        <?php 
	          }
			?>
	    </table>
		<p></p>
		<h2>Récapitulatif des justificatifs fournis</h2>
		<input disabled type="text" class="zone" size="4" name="nbJustificatifs" value="<?php echo $nbJustificatifs ?>"></input>	
		<p></p>
		
		<a href="index.php?uc=suiviPaiement&action=miseEnPaiement" 
			
				onclick="return confirm('Voulez-vous vraiment mettre en paiement cette fiche de frais ?');" class="button">Mettre en paiement</a> 
		<a href="index.php?uc=generationPDF&action=genererPDF" 
					onclick="return confirm('Vous allez générer la facture au format PDF, merci de n'imprimer que le stricte nécessaire au suivi comptable.');" class="button">Créer Fiche Frais PDF</a> 
	</form>

</div>