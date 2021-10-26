<?php
	header('Content-Type: text/html; charset=UTF-8');
	session_start();
    require "../Model/ChiffresEnLettres.php";
	ob_get_clean();
	 require '../fpdf/fpdf.php';
	
	 if(isset( $_SESSION['id']) AND isset($_SESSION['datres']) AND isset($_SESSION['hres']) AND isset($_SESSION['j'])  AND isset($_SESSION['nc']) AND isset($_SESSION['pnc']) AND isset($_SESSION['s']) AND isset($_SESSION['a']) AND isset( $_SESSION['m']) AND isset($_SESSION['datar']) AND isset( $_SESSION['datdep']) AND isset($_SESSION['ob']))
	 {
	 	$date = date("d/m/Y");
	 	//creation du document on ouvre une session
		$pdf = new FPDF('P','mm','A4');//on precise les orientations

		 //on ajoute la page
		$pdf->AddPage();

		//on met le titre
		$pdf->SetFont('arial','B',14);
		
		$pdf->Cell(20,10,'','', 0);
		$pdf->Cell(40,10,utf8_decode('LES RESIDENCES ANNEKAM'), '', 1);
		$pdf->Cell(20,20,'','', 1);

		//on met la police

		$pdf->SetFont('courier','',10);

		// on va créer maintenant les céllules qui vont afficher nos données

		//creation des entêtes

		$pdf->Cell(0, 40,'','', 1);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(50,10,utf8_decode('RESEERVATION N°  '.$_SESSION["id"].''), '', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'Abidjan le '.$date.'', '', 1);

		$pdf->SetFont('courier','B',10);
		$pdf->Cell(0, 10,'','', 1);
		$pdf->Cell(0, 0,'CLIENT:	'.$_SESSION['nc'].'  '.$_SESSION['pnc'].'','', 1, 'C');
		
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(0, 10,'','', 1);
		$pdf->Cell(40,10,utf8_decode('Objet de la réservation:  '), '', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(50, 10,utf8_decode(''.$_SESSION['ob'].''),'', 1);

		$pdf->SetFont('courier','B',10);
		$pdf->Cell(30,10,'Appartement: ', '', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(10, 10,''.$_SESSION['a'].'','', 1);


		$pdf->Cell(0, 10,'','', 1);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(30,10,utf8_decode('Date de la réservation: '), '', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(10,10,''.$_SESSION['datres'].'', '', 0);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(30,10,utf8_decode('Heure de la réservation: '), '', 0);
		$pdf->Cell(30, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(10,10,''.$_SESSION['hres'].'', '', 1);

		$pdf->Cell(0, 10,'','', 1);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(20,10,utf8_decode('Date d\'arrivée:  '), '', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->Cell(10,10,''.$_SESSION['datar'].'','', 0);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->Cell(20,10,utf8_decode('Durée du séjour:'), '', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(10,10,''.$_SESSION['j'].' Jour(s)', '', 1);


		$pdf->SetFont('courier','B',10);
		$pdf->Cell(20,10,utf8_decode('Date de départ:'), '', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(10, 10,''.$_SESSION['datdep'].'','', 1);

		$pdf->SetFont('courier','B',10);
		$pdf->Cell(0, 10,'','', 1);
		$pdf->Cell(20, 10,'MONTANT DE LA RESERVATION: ','', 0);
		$pdf->Cell(35, 10,'','', 0);
		$pdf->SetFont('courier','',10);
		$pdf->Cell(30, 10,''.number_format($_SESSION['m'], 0, ',', ' ').'','', 0);
		//mettre en gras le satatue de la réservation
		$pdf->Cell(0, 10,'','', 1);
		
		// verification pour dire si la réservation est soldée ou pas
		if(intval($_SESSION['s'] == 0))
	    {
	    	$pdf->SetFont('courier','B',10);
	    	$pdf->Cell(15, 10,'NB :','', 0);
	    	$pdf->Cell(5, 10,'','', 0);
	    	$pdf->SetFont('courier','',10);
	    	$pdf->Cell(20, 10,'RESERVATION NON SOLDEE', '', 1, '' );
	    }
	    else
	    {
	    	$pdf->SetFont('courier','B',10);
	    	$pdf->Cell(15, 10,'NB :','', 0);
	    	$pdf->Cell(5, 10,'','', 0);
	    	$pdf->SetFont('courier','',10);
	    	$pdf->Cell(20, 10,'RESERVATION SOLDEE', '', 1, '' );
	    }

	    $pdf->Cell(0, 20,'','', 1);
	     $pdf->Cell(100, 10,'','', 0);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(40, 10,utf8_decode('La Direction Générale :'),'', 1);
		//afficher maintenant le pdf
		$pdf->Output('', '', 'isUTF8: true');
		ob_clean();
	}
	else
	{
		echo'Oups une erreu est survenue<a href="../admin/reservation">retour</a>';
	}

?>
