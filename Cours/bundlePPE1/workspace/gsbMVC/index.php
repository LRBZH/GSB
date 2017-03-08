<?php

require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if(!isset($_REQUEST['uc']) || !$estConnecte){
	$_REQUEST['uc'] = 'connexion';
}
//----------requêtes "uc" pour appel des pages"
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break; //Connexion
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break; //Visiteur
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; //Visiteur
	}
	case 'validerFicheFrais' :{
		include("controleurs/c_validerFicheFrais.php");break; //Comptable
	}
	case 'suiviPaiementFicheFrais' :{
		include("controleurs/c_");break; //Comptable
	}
}
include("vues/v_pied.php") ;
?>
   