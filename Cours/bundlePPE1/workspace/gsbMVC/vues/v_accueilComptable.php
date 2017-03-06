<div id="accueil">
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>ACCUEIL COMPTABLE</h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  Comptable :<br>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?><br /><br />
			</li>
           <li class="smenu">
              <a href="index.php?uc=validerFicheFrais&action=consulterFicheFrais" title="Valider la fiche de frais d'un visiteur">Valider la fiche de frais d'un visiteur</a><br />
           </li>
           <li class="smenu">
              <a href="index.php?uc=validerFicheFrais&action=suiviPaiementFicheFrais" title="Suivre le paiement d'une fiche de frais visiteur">Suivre le paiement d'une fiche de frais visiteur</a><br />
           </li>
           <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a><br />
           </li>
         </ul>     
    </div>
</div>
