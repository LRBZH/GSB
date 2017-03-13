
	<form method="POST" action="index.php?uc=validerFicheFrais&action=majFraisForfait">
	<h2>Frais au forfait </h2>
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
	                <td class="qteForfait"><input id="idFrais" class="inputSmall" name="lesFrais[<?php echo $idFrais?>]" value="<?php echo $quantite?>" ></input> </td>
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
	  
		<h2>Hors forfait</h2>   		
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
	                <td><input value="<?php echo $libelle ?>" disabled></input></td>
	                <td><input class="inputSmall" value="<?php echo $montant ?>" disabled></input></td>
	                <td><a href="index.php?uc=validerFicheFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
					onclick="return confirm('Voulez-vous vraiment refuser ce frais?');">Refuser</a></td>
	             </tr>
	        <?php 
	          }
			?>
	    </table>
		<p></p>
		<h2>Nombre de justificatifs fournis</h2>
		<input type="text" class="zone" size="4" name="nbJustificatifs" value="<?php echo $nbJustificatifs ?>"></input>	
		<p></p>
		<input class="zone"type="submit" value="Enregistrer les modifications" onclick="return confirm('Voulez-vous vraiment enregistrer les modifications ?');" />
		<p></p>
		
		<a href="index.php?uc=validerFicheFrais&action=validerFicheFrais" 
					onclick="return confirm('Voulez-vous vraiment valider cette fiche de frais ?');" class="button">Valider la fiche</a> 
		<a href="index.php?uc=generationPDF&action=genererPDF" 
					onclick="return confirm('Vous allez générer la facture au format PDF, merci de n'imprimer que le stricte nécessaire au suivi comptable.');" class="button">Créer Fiche Frais PDF</a> 
	</form>

</div>