<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion'; 
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		$comptable = $pdo->getInfosComptable($login,$mdp);
		
		if(!is_array($visiteur) && !is_array($comptable)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		elseif (is_array($visiteur)){
			$choix="visiteur"; //pour la couleur de la page d'accueil
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
			include("vues/v_accueil.php");
		}
		elseif (is_array($comptable)){
			$choix="comptable"; //pour la couleur de la page d'accueil
			$id = $comptable['id'];
			$nom =  $comptable['nom'];
			$prenom = $comptable['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_accueilComptable.php");
			include("vues/v_accueil.php");
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>