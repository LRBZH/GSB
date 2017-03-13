<?php
include("vues/v_accueilComptable.php");
//Variable globales
$idComptable = $_SESSION['id'];
$action = $_REQUEST['action'];

/**
 * Actions reçues de la vue
 */
switch($action){
	//Premier choix du menu de gauche du comptable
	case 'consulterFicheFrais':{
		$lesVisiteurs=$pdo->getLesVisiteurs();
		
		include("vues/v_listeVisiteursPourCompta.php");
		break;
	}
	
	//Le comptable a choisi un visiteur, on affiche les mois liés à ce visiteur
	case 'selectionnerVisiteur':{
		$idVisiteur = $_REQUEST['idVisiteur'];
		setCookie("idVis",$idVisiteur);
		$leVisiteur=$pdo->getLeVisiteur($idVisiteur);
		$nomVisiteur = $leVisiteur['nom'];
		$prenomVisiteur = $leVisiteur['prenom'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		if($lesMois == null){
			echo '<script language="javascript">';
			echo 'alert("Pas de fiche en attente de paiement pour ce visiteur.")';
			echo '</script>';
			include("vues/v_listeVisiteursPourCompta.php");
		}else{
			// Afin de sélectionner par défaut le dernier mois dans la zone de liste
			// on demande toutes les clés, et on prend la première,
			// les mois étant triés décroissants
			$lesCles = array_keys( $lesMois );
			$moisASelectionner = $lesCles[0];
			include("vues/v_listeMoisParVisiteur.php");
		}
		break;
	}
	
	//le comptable a choisi un mois pour ce visiteur, on affiche le contenue de la fiche de frais
	case 'selectionnerMois':{	
		//Le visiteur choisi
		$idVisiteur = $_COOKIE['idVis'];
		$leVisiteur=$pdo->getLeVisiteur($idVisiteur);
		$nomVisiteur = $leVisiteur['nom'];
		$prenomVisiteur = $leVisiteur['prenom'];
		
		//Le mois choisi
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;		
		setCookie("idMois",$leMois);
		include("vues/v_listeMoisParVisiteur.php");
		
		//La fiche de frais concernée
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);		
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);	
		$lesEtats = $pdo->getLesEtats();		
		$leLibEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
	
		include("vues/v_validerFicheFrais.php");
		break;
	}
	
	//Le comptable refuse un frais hors-forfait
	case 'supprimerFrais' :{
		$idVisiteur = $_COOKIE['idVis'];
		$mois = $_COOKIE['idMois'];
		$idFrais = $_REQUEST['idFrais'];
		
		//Récupération du frais et modification du libellé qui commencera par REFUSE ...
		$leFraisHF = $pdo->getLibelleFraisHorsForfaitById($idFrais);
		$leLibelle = $leFraisHF['libelle'];
		$message = "REFUSE ".$leLibelle;
		$pdo->refuserFraisHorsForfait($idFrais, $message);
		
		
		//script pour la pop-up de confirmation
		echo '<script language="javascript">';
		echo 'alert("Frais refusé")';
		echo '</script>';
		
		$leVisiteur=$pdo->getLeVisiteur($idVisiteur);
		$nomVisiteur = $leVisiteur['nom'];
		$prenomVisiteur = $leVisiteur['prenom'];
		
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $mois;
		include("vues/v_listeMoisParVisiteur.php");
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisASelectionner);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisASelectionner);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisASelectionner);
		$numAnnee =substr( $moisASelectionner,0,4);
		$numMois =substr( $moisASelectionner,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_validerFicheFrais.php");
		
		break;
	}
	
	/**
	 * Le comptable a modifié les frais forfaitisés et enregistre
	 */
	case 'majFraisForfait' :{
		$idVisiteur = $_COOKIE['idVis'];
		$mois = $_COOKIE['idMois'];
		$lesFrais = $_REQUEST['lesFrais'];
		$nbJustifs = $_REQUEST['nbJustificatifs'];
		
		//maj des données
		if(lesQteFraisValides($lesFrais)){
			$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}	
		
		$pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustifs);
		
		//script pour la pop-up de confirmation
		echo '<script language="javascript">';
		echo 'alert("Fiche mise à jour")';
		echo '</script>';
				
		//réaffichage
		
		$leVisiteur=$pdo->getLeVisiteur($idVisiteur);
		$nomVisiteur = $leVisiteur['nom'];
		$prenomVisiteur = $leVisiteur['prenom'];
		
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $mois;
		include("vues/v_listeMoisParVisiteur.php");
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisASelectionner);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$moisASelectionner);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$moisASelectionner);
		$numAnnee =substr( $moisASelectionner,0,4);
		$numMois =substr( $moisASelectionner,4,2);
		$lesEtats = $pdo->getLesEtats();
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_validerFicheFrais.php");
		
		break;
	}
	
	//Le comptable passe la fiche de frais à l'état Validé
	case 'validerFicheFrais' :{
		//Récup des infos pour affichage pop-up
		$idVisiteur = $_COOKIE['idVis'];
		$mois = $_COOKIE['idMois'];
		$etat = "VA";

		//Passage de la fiche à l'état validé + dateModif = now()
		$pdo->majEtatFicheFrais($idVisiteur,$mois,$etat);
				
		//script pour la pop-up de confirmation
		echo '<script language="javascript">';
		echo 'alert("Fiche validée.")';
		echo '</script>';
		
		break;
	}
	
}





?>