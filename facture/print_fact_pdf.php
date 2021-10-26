<?php
	session_start();
    //require "../phps/ChiffresEnLettres.php";
	ob_get_clean();
	require '../fpdf/fpdf.php';
	

	 if(isset($_SESSION['i']) AND isset($_SESSION['n']) AND isset($_SESSION['p']) AND isset($_SESSION['d']) AND isset($_SESSION['a'])  AND isset($_SESSION['j']) AND isset($_SESSION['tj']) AND isset($_SESSION['pay']) AND isset($_SESSION['rest']) AND isset($_SESSION['mr']) AND isset($_SESSION['s']))
	 {
	 	$timestampd = strtotime($_SESSION['d']);//recuperation du timestanp de la date donnée
		$new_format = date("d/m/Y", $timestampd);//changement du format
	 	//creation du document on ouvre une session
		$pdf = new FPDF('P','mm','A4');//on precise les orientations

		 //on ajoute la page
		$pdf->AddPage();

		//on met le titre
		$pdf->SetFont('arial','B',12);
		
		$pdf->Cell(10,10,'','', 0);
		$pdf->Cell(40,10,utf8_decode('LES RESIDENCES ANNEKAM'), '', 1);
		$pdf->Cell(10,20,'','', 1);

		//on met la police

		$pdf->SetFont('courier','',12);

		// on va créer maintenant les céllules qui vont afficher nos données
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,'','', 1);
		//creation des entêtes
		$pdf->Cell(15,10,'','', 0);
		$pdf->Cell(50,10,utf8_decode('Facture N°  '.$_SESSION['i'].''), '', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(60,10,'Abidjan le '.$new_format.'', '', 1);
	
		$pdf->Cell(50,10,'', '', 0);
		$pdf->Cell(50, 10,utf8_decode('Délivrée à:	'.$_SESSION['n'].'  '.$_SESSION['p'].''),'', 0);
		$pdf->Cell(60,10,'', '', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->Cell(50, 10,utf8_decode('Objet : Location d\'appartement(s) meublé(s)'),'', 0);
		$pdf->Cell(50,10,'', '', 0);
		$pdf->Cell(60,10,'', '', 1);
		
		$pdf->Cell(0, 25,'','', 1);
		$pdf->Cell(15,10,'','', 0);
		$pdf->SetFont('courier','B',12);
		$pdf->Cell(20, 10,'DESIGNATION','TB', 0);
		$pdf->Cell(20, 10,'','TB', 0);
		$pdf->Cell(20, 10,'UNITE','TB', 0);
		$pdf->Cell(10, 10,'','TB', 0);
		$pdf->Cell(20, 10,'QUANTITE','TB', 0);
		$pdf->Cell(20, 10,'','TB', 0);
		$pdf->Cell(20, 10,'PRIX UNITAITRE','TB', 0);
		$pdf->Cell(20, 10,'','TB', 0);
		$pdf->Cell(20, 10,'TOTAL','TB', 1);
		$pdf->Cell(0, 0,'','', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->SetFont('courier','',12);
		$pdf->Cell(20, 10,''.$_SESSION['a'].'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'U','', 0);
		$pdf->Cell(10, 10,'','', 0);
		$pdf->Cell(20, 10,''.$_SESSION['j'].'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		//pour dire si le nombre de jour atteint 30 on doit faire afficher le tarif du mois
		if($_SESSION['j']==28 OR $_SESSION['j']==29)
        {
           $pdf->Cell(20, 10,''.number_format(round(($_SESSION['tm']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'','', 0);
        }
          elseif($_SESSION['j']==30)
        {
            $pdf->Cell(20, 10,''.number_format(round(($_SESSION['tm']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'','', 0);
        }
        else
        {
            $pdf->Cell(20, 10,''.number_format(round(($_SESSION['tj']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'','', 0);
        }
        $pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,''.number_format(round(($_SESSION['mr']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'','', 1);
		$pdf->Cell(0, 0,'','', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(10, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'TVA 18%','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,''.number_format(round(($_SESSION['mr']/1.18)*0.18, 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'','', 1);
		$pdf->Cell(0, 0,'','', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(10, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		//verifier si c'est une facture proformat
		if($_SESSION['s']==0 AND $_SESSION['rs']==0)
		{
			
		}
		else
		{
			$pdf->Cell(20, 10,'ACOMPTE','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,''.number_format($_SESSION['pay'], 0, ',', ' ').'','', 1);
		}
		$pdf->Cell(0, 0,'','', 1);

		//verification sur le rest
		if($_SESSION['rest']<0)
		{
			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(10, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'MONTANT TTC','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,''.number_format($_SESSION['mr'], 0, ',', ' ').'','', 1);
			$pdf->Cell(0, 0,'','', 1);

			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(10, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'A REMBOURSER','B', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,''.number_format((-1*$_SESSION['rest']), 0, ',', ' ').'','B', 1);
		
		}
		elseif($_SESSION['rest']==0)
		{
			
			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(10, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'MONTANT TTC','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,''.number_format($_SESSION['mr'], 0, ',', ' ').'','', 1);
			$pdf->Cell(0, 0,'','', 1);

			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(10, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'RESTE A PAYER','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'0 FCFA','B', 1);
			
		}
		else
		{
			
			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(10, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,'MONTANT TTC','', 0);
			$pdf->Cell(20, 10,'','', 0);
			$pdf->Cell(20, 10,''.number_format($_SESSION['mr'], 0, ',', ' ').'','', 1);
			$pdf->Cell(0, 0,'','', 1);

			$pdf->Cell(15,10,'','', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(10, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,'RESTE A PAYER','B', 0);
			$pdf->Cell(20, 10,'','B', 0);
			$pdf->Cell(20, 10,''.number_format($_SESSION['rest'], 0, ',', ' ').'','B', 1);
			
		}
		$pdf->Cell(0, 15,'','', 1);

		//ecrire le montant en lettre
		$pdf->Cell(15,10,'','', 0);
		$pdf->SetFont('courier','',10);
		//Formater de sorte a afcciher en lettre
		$fmt = new NumberFormatter( 'en_EN', NumberFormatter::DECIMAL ); //créer un format et comme notre nombre est décimal donc décimal
		$num = $fmt->parse($_SESSION['pay']);
		$int = $fmt->parse($num, NumberFormatter::TYPE_INT32);//ensuite rendre entier
		$f = new NumberFormatter("fr_FR", NumberFormatter::SPELLOUT);// et enfin ecrire en chifre
		$w = $f->format($int);
		$pdf->Cell(0, 5, utf8_decode('Arrêter de la présente  facture a somme de :'), '', 1);
		$pdf->Cell(20,5,'','', 0);
		$pdf->Cell(0, 5,utf8_decode(''.ucfirst($w).' FCFA'), '', 1);
		$pdf->Cell(0, 20,'','', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->SetFont('courier','B',10);
		$pdf->Cell(50,10,'', '', 0);
		$pdf->Cell(50,10,'','', 0);
		$pdf->Cell(50,10,utf8_decode('La Direction Générale : '), '', 1);
		$pdf->Cell(0, 10,'','', 1);

		$pdf->Cell(15,10,'','', 0);
		$pdf->SetFont('courier','B',12);
		$pdf->Cell(170, 10,utf8_decode('Nos références'),'TB', '', 'C');
		$pdf->Cell(0, 10,'','', 1);

		$pdf->SetFont('courier','',10);

		$pdf->Cell(15,10,'','', 0);
		$pdf->Cell(20, 10,'Domiciliation: BANK OF AFRICA','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(20, 10,'IBAN: CI93 CI03 2010 1300 6099 2100 0584','', 0);
		$pdf->Cell(20, 10,'','', 0);
		$pdf->Cell(30, 20,'','', 1);

		$pdf->Cell(10, 5,'','', 0);
		$pdf->Cell(10, 5,'Banque','', 0);
		$pdf->Cell(5, 10,'','', 0);
		$pdf->Cell(10, 5,'Guichet','', 0);
		$pdf->Cell(15, 5,'','', 0);
		$pdf->Cell(10, 5,'Compte','', 0);
		$pdf->Cell(15, 5,'','', 0);
		$pdf->Cell(10, 5,utf8_decode('Clé RIB'),'', 1);

		$pdf->Cell(10, 0,'','', 0);
		$pdf->Cell(10, 10,'CI032','', 0);
		$pdf->Cell(5, 10,'','', 0);
		$pdf->Cell(10, 10,'1013','', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->Cell(10, 10,'6099210005','', 0);
		$pdf->Cell(15, 10,'','', 0);
		$pdf->Cell(10, 10,'84','', 1);
		//afficher maintenant le pdf
		$pdf->Output();
		ob_clean();
	}
	else
	{
		echo'Oups une erreur est survenue<a href="../admin/fact">retour</a>';
	}

?>
