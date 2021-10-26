<?php
	//ici est l'etat pdf du rapport
	session_start();
    //require "../phps/ChiffresEnLettres.php";
	ob_get_clean();
	require '../fpdf/fpdf.php';
	
	//connexion a la base de données
	try
    {
    	$bdd = new PDO('mysql:host=127.0.0.1;dbname=appart;charset=utf8','root','');
    }
    catch(Exception $e)
    {
    	die('Erreur: '. $e->getMessage());
    }


	if(isset($_SESSION['num_an']) AND isset($_SESSION['num_mois']) AND isset($_SESSION['number']))
	{
		unset($_SESSION['month']);
		unset($_SESSION['year']);
		
		
	 	//faire les dates de debut et de fin
	 	$dd = $_SESSION['num_an']."-".$_SESSION['num_mois'].'-01';
		$df = $_SESSION['num_an']."-".$_SESSION['num_mois'].'-'.$_SESSION['number'];
		//montant total
		$tot = 0;
	 	//creation du document on ouvre une session
		$pdf = new FPDF('P','mm','A4');//on precise les orientations

		//on ajoute la page
		$pdf->AddPage();

		//on met le titre
		$pdf->SetFont('arial','B',12);
		$mois = ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'];
		$pdf->Cell(20,10,'','', 0);
		$pdf->Cell(40,10,utf8_decode('ENTRETIENS: '.$mois[($_SESSION['num_mois']-1)].' '.$_SESSION['num_an']), '', 1);

		//on met la police

		$pdf->SetFont('arial','B',9);

		// on va créer maintenant les céllules qui vont afficher nos données

		//creation des entêtes
		$pdf->Cell(2,10,'','', 0);
		$pdf->Cell(20,10,utf8_decode('APPARTEMENT'), 'LTB', 0);
		$pdf->Cell(10,10,'','TB', 0);
		$pdf->Cell(85,10,'ENTRETIEN', 'TB', 0);
		$pdf->Cell(15,10,'','TB', 0);
		$pdf->Cell(20,10,'DATE', 'TB', 0);
		$pdf->Cell(15, 10, '', 'TB', 0);
		$pdf->Cell(20,10, utf8_decode('MONTANT'), 'TBR', 1);
		
		$pdf->SetFont('arial','',9);

		//on ecrit le code pour afficher les mouvements 
		$reservation = $bdd->query("SELECT SQL_NO_CACHE e.lib_ent, e.mont_entretien, e.dat_op, a.lib_appart, e.mont_entretien, e.id_ent FROM entretien e, appartement a WHERE e.id_appart=a.id_appart  AND e.dat_op BETWEEN '".$dd."' AND '".$df."' ");
		
		//les lignes
		while($fetch = $reservation->fetch())
		{
			$pdf->Cell(2,10,'','', 0);
			$pdf->Cell(20,10,utf8_decode($fetch[3]), 'LTB', 0);
			$pdf->Cell(10,10,'','TB', 0);
			$pdf->Cell(85,10, $fetch[0], 'TB', 0);
			$pdf->Cell(15,10,'','TB', 0);
			$pdf->Cell(20,10, $fetch[2], 'TB', 0);
			$pdf->Cell(15, 10, '', 'TB', 0);
			$pdf->Cell(20,10, utf8_decode($fetch[1]), 'TBR', 1);
			

			$tot +=  $fetch[1];
		}
		$pdf->Cell(2,10,'','', 0);
		$pdf->Cell(100,10,utf8_decode('TOTAL'), 'LTB', 0);
		$pdf->Cell(35,10,'','TB', 0);
		$pdf->Cell(50,10,''.number_format($tot, 0, ',', ' ').'', 'TBR', 0);
		
		//afficher maintenant le pdf
		$pdf->Output();
		ob_clean();
	}
	else
	{
		echo'Oups une erreur est survenue<a href="table.php">retour</a>';
	}


	
	


?>
