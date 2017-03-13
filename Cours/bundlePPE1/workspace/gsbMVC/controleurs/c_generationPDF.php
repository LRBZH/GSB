<?php
//Includes
require('fpdf.php');
include("vues/v_accueilComptable.php");

//Variable globales
$idComptable = $_SESSION['id'];
$action = $_REQUEST['action'];

/**
 * Actions reçues de la vue
 */
if ($action == 'genererPDF'){
	
	//Redéfinition de la classe PDF pour gestion de la mise en page 
	class PDF extends FPDF
	{
		// En-tête
		function Header()
		{
			// Logo
			$this->Image('images/logo.jpg',10,6,30);
			// Police Courier gras 15
			$this->SetFont('Courier','BI',15);
			
			// Décalage à droite
			$this->Cell(80);
			// Titre
			$titre = "Remboursement de frais engagés";
			$titre = utf8_decode($titre);
			$this->Cell(30,10,$titre,0,0,'C');
			// Saut de ligne
			$this->Ln(20);
		}
		
		// Pied de page
		function Footer()
		{
			// Positionnement à 1,5 cm du bas
			$this->SetY(-15);
			// Police Courier italique 8
			$this->SetFont('Courier','I',8);
// 			// Numéro de page
// 			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			// Texte libre
			$this->Cell(0,10,'Document comptable GSB - Diffusion restreinte',0,0,'C');
		}
	
	// Chargement des données
	function LoadData($file)
	{
		// Lecture des lignes du fichier
		$lines = file($file);
		$data = array();
		foreach($lines as $line)
			$data[] = explode(';',trim($line));
			return $data;
	}

	
	
	// Tableau infos fraisForfait
	function tableauFraisForfait($header, $data)
	{
 		// En-tête
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('','I');
		$w = array(60,40,45,35);
		for($i=0;$i<count($header);$i++){
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		}
		$this->Ln();
		// Restauration des couleurs et de la police
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Données
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,utf8_decode($row[0]),'LR',0,'L',$fill);
			$this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
			$this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Trait de terminaison
		$this->Cell(array_sum($w),0,'','T');
	}
	
	// Tableau infos fraisHorsForfait
	function tableauFraisHorsForfait($header, $data)
	{
		// En-tête
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('','I');
		$w = array(120,35,25);
		for($i=0;$i<count($header);$i++){
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		}
		$this->Ln();
		// Restauration des couleurs et de la police
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Données
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,utf8_decode($row[0]),'LR',0,'L',$fill);
			$this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Trait de terminaison
		$this->Cell(array_sum($w),0,'','T');
	}
	
}	
	
	//Génération du PDF		
	$pdf = new PDF('P','mm','A4');
	$pdf->AddPage();	
	$pdf->SetFont('Courier','',12);
	
	//Données visiteur-------------------------	
	$pdf->ln(10);
	$leVisiteur=$pdo->getLeVisiteur('f4');
	$nomVisiteur = $leVisiteur['nom'];
	$prenomVisiteur = $leVisiteur['prenom'];
	
	$leMois='2017-02';
	$numAnnee =substr($leMois,0,4);
	$numMois =substr($leMois,5,2);
	
	$str1 = $nomVisiteur." ".$prenomVisiteur;
	$str1 = utf8_decode($str1);
	$str2 = "Fiche de frais de : ".$numMois." - ".$numAnnee;			
	$str2 = utf8_decode($str2);
	
	$pdf->Cell(40,10,$str1,'',1);
	$pdf->Cell(40,10,$str2,'',1);
	
	//A la ligne
	$pdf->Ln(10);
	
	//Tableau données frais forfait----------------------------------------------
	$headerFraisForfait = array("Frais Forfaitaires", utf8_decode("Quantité"), "Montant unitaire", "Total");
	$lesFraisForfait= $pdo->getLesFraisForfaitLite('f4','201702');
	$pdf->tableauFraisForfait($headerFraisForfait, $lesFraisForfait);
	$totalFf = $pdo->getTotalFraisForfait('f4', '201702');
	$pdf->ln(1);
	$pdf->Cell(30,10,$totalFf,1,1,'L');
	$pdf->ln(1);
	
	//A la ligne
	$pdf->Ln(10);
	$pdf->Cell(30,10,"Autres frais",0,0,'C');
	$pdf->Ln(10);
	
	//Tableau données frais hors forfait------------------------------------
	$headerFraisHorsForfait = array("Frais", "Date", "Montant");
	$lesFraisHorsForfait= $pdo->getLesFraisHorsForfaitLite('f4','201702');
	$pdf->tableauFraisHorsForfait($headerFraisHorsForfait, $lesFraisHorsForfait);
	$pdf->Ln(1);
	
	$pdf->Cell(30,10,utf8_decode("TOTAL "),1,1,'R');

	
	$pdf->ln(20);
		
	$pdf->Cell(10,10,utf8_decode("Fait à Paris, le : "),0,1,'L');
	$pdf->Cell(80,10,"Vu l'agent comptable : ",0,1,'L');
	$pdf->Cell(80,40,"",1,1,'L');
	
	$pdf->Output();

} 
//------------------------------- NOTES ---------------------------------
/* Memo perso sur les syntaxes du PDF :
 * 
 * Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
 * default : ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
 * 
 * Décodage pour les accents: 
 * // 	$str = "Hello World !! Miaww ^^ ";
 * // 	$str = utf8_decode($str);
 * // 	$pdf->Cell(40,10,$str);
 */
?>

