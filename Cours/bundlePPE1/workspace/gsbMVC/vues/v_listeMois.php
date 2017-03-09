   <div class = "visiteur">
      <div class="corpsForm">
      <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
	      
	         <h2>Mes fiches de frais</h2>	 
		        <label for="lstMois" accesskey="n">Choisir le mois : </label>
		        <select id="lstMois" name="lstMois">
		            <?php
					foreach ($lesMois as $unMois)
					{
					    $mois = $unMois['mois'];
						$numAnnee =  $unMois['numAnnee'];
						$numMois =  $unMois['numMois'];
						if($mois == $moisASelectionner){
						?>
						<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
						<?php 
						}
						else{ ?>
						<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
						<?php 
						}			
					}          
				   ?>               
		        </select>
				<input id="ok" type="submit" value="Valider" size="20" />
				<input id="annuler" type="reset" value="Effacer" size="20" />
	      </div>       
   </form>
