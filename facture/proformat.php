<?php
 	session_start();

	include("../Model/confige.php");
    //include("../phps/ChiffresEnLettres.php");
    require"../Model/Reservation.php";
    require '../Model/Facture.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Facture</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">

	<link rel="stylesheet" type="text/css" href="../css/fmain.css">
<!--===============================================================================================-->


<script>
function imprimer(divName) {
      var printContents = document.getElementById(divName).innerHTML;    
   var originalContents = document.body.innerHTML;      
   document.body.innerHTML = printContents;     
   window.print();     
   document.body.innerHTML = originalContents;
   }
</script>
</head>
<body>

	<?php
	if(isset($_POST['buy']))
	{
		//on va v??rifier si la r??servation est d??ja sold??e
		$vres = $bdd->query('SELECT statut FROM reservation WHERE statut=1 AND id_reserv="'.$_SESSION['reserv'].'"');
		$row =$vres->fetchAll();
		$n = count($row);
		if($n == 0)// reservation non sold??e
		{
			//modification de la r??servation
			$s = (new reservation())->update_statut($_SESSION['reserv']);

			//il faut donc cr??er une facture en mettant cette fois ci le reste 0
			$date = date("Y-m-d");
			$hr = date("H:i:s");
			$idfact = "F".rand(0,10000);//id de facture
			$restant = 0; 
			$g =  4; // pour l'identifiant du mode de payement
			$insert = (new facture())->insertfact($idfact, $_SESSION['montant'],  $_SESSION['reserv'], $date, $restant, $hr, $g);
			echo'<h3>Facture enregistr??e en tant que pay??(e); R??servation sold??e</h3>';
		}
		else//reservation sold??e
		{
			echo'<h3>Facture d??j?? enregistr??e en tant que pay??(e); R??servation sold??e</h3>';
		}
		
	}
	
	?>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">

				<div class="table" id="sectionAimprimer">
				<?php

					$num_mois = date('n');
					if(isset($_SESSION['appart']) AND isset( $_SESSION['nom']) AND isset($_SESSION['pnom']) AND isset($_SESSION['date']) AND isset($_SESSION['newdate1']) AND isset($_SESSION['montant']) AND isset($_SESSION['desig'])  AND isset( $_SESSION['j']) AND isset($_SESSION['reserv']))
					{
							echo'<div class="row header" style="font-weight:bold; color: #292929;">
							<div class="cell" style="font-weight:bold; color: #292929;">FactureN??'.$_SESSION['fact'].'</div><div class="cell"></div><div class="cell"></div><div class="cell" style="font-weight:bold; color: #292929;">Abidjan le '.$_SESSION['date'].'</div><div class="cell"></div>
							</div>';
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">Doit: '.$_SESSION['nom'].'  '.$_SESSION['pnom'].'</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" style="font-weight:bold; color: #292929;"><u>Objet</u>:</div><div class="cell"  style="font-size:9.5px">Location d\'appartement meubl??</div><div class="cell" ></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row header" style="font-weight:bold; color: #292929;">
								<div class="cell" style="font-weight:bold; color: #292929;">DESIGNATION</div><div class="cell" style="font-weight:bold; color: #292929;">UNITE</div><div class="cell" style="font-weight:bold; color: #292929;">QUANTITE</div><div class="cell" style="font-weight:bold; color: #292929;">PRIX UNITAIRE</div><div class="cell" style="font-weight:bold; color: #292929;">TOTAL</div>
								</div>';
							
							echo'<div class="row" style="font-weight:bold; color: #292929;">
							<div class="cell" style="font-weight:bold; color: #292929;">'.$_SESSION['desig'].'</div>
							<div class="cell" style="font-weight:bold; color: #292929;">U</div>
							<div class="cell" style="font-weight:bold; color: #292929;">'.$_SESSION['j'].' JOURS</div>
							<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(($_SESSION['p1']/1.18), 0, ',', ' ').'</b></div>';
							if($_SESSION['j']<30)
							{
								echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round((($_SESSION['p1']*$_SESSION['j'])/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>
							</div>';
							}
							else
							{
								echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round((($_SESSION['p1']/1.18)), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>
							</div>';
							}
							
							//montant de la remise
							
							if($_SESSION['j']<30)
							{
								$mdr =(($_SESSION['p1'])*$_SESSION['j'])*($_SESSION['remise']/100);
							}
							else
							{
								$mdr =(($_SESSION['p1']))*($_SESSION['remise']/100);
							}

							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">TVA 18%</div>';

							if($_SESSION['j']<30)
							{
								echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round( ( ( $_SESSION['p1']*$_SESSION['j'] )/1.18 )*0.18, 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>';
							}
							else
							{
								echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round( ( $_SESSION['p1']/1.18 )*0.18, 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>';
					
							}	
							//echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round(($_SESSION['montant']*0.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>';
							echo'</div>';

							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">MONTANT DE LA REMISE</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round($mdr, 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>
								</div>';

							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">MONTANT TOTAL TTC</div>';
							echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>';
							
							echo'</div>';

							
							
							
							
							//verifier si la facture au d??but qui est proformat est enregistr??e maintenant en tant que facture pay??e
							if(isset($idfact))
							{
								//creation de sa session pour aller dans le pdf avec
								$_SESSION['fact'] = $idfact;
								$verif = $bdd->query('SELECT s FROM facture WHERE id_fact="'.$idfact.'"');
								while($obtenir = $verif->fetch())
								{
									$_SESSION['s'] = $obtenir[0] ;
									if(intval($obtenir[0]) == 1)// c'est pay?? donc on affiche les infos de la facture
									{

										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" >ACCOMPTE</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>
								</div>'; 
										echo'<div class="row" style="font-weight:bold; color: #292929;">
									<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">RESTE A PAYER</div><div class="cell"style="font-weight:bold; color: #292929;"b>0 FCFA</b></div>
									</div>';		

									}
									else
									{
										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">ACCOMPTE (FCFA)</div><div class="cell" style="font-weight:bold; color: #292929;">0</div>
								</div>'; 
										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">RESTE A PAYER</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>
								</div>';
									}
								}

							}
							else
							{
								$verif = $bdd->query('SELECT s FROM facture WHERE id_fact="'.$_SESSION['fact'].'"');
								while($obtenir = $verif->fetch())
								{
									$_SESSION['s'] = $obtenir[0] ;
									if(intval($obtenir[0]) == 1)// c'est pas pay?? donc on affiche les infos de la facture
									{
										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" >ACCOMPTE</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>
								</div>'; 
										echo'<div class="row" style="font-weight:bold; color: #292929;">
									<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">RESTE A PAYER</div><div class="cell"style="font-weight:bold; color: #292929;"b>0 FCFA</b></div>
									</div>';

									}
									else
									{
										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">ACCOMPTE (FCFA)</div><div class="cell" style="font-weight:bold; color: #292929;">0</div>
								</div>'; 
										echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">RESTE A PAYER</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>
								</div>';
									}
								}
							}
							

							//$lettre=new ChiffreEnLettre();
							//$l = $lettre->Conversion($_SESSION['montant']);
							//Formater de sorte a afcciher en lettre
							$fmt = new NumberFormatter( 'en_EN', NumberFormatter::DECIMAL ); //cr??er un format et comme notre nombre est d??cimal donc d??cimal
							$num = $fmt->parse($_SESSION['montant']);
							$int = $fmt->parse($num, NumberFormatter::TYPE_INT32);//ensuite rendre entier
							$f = new NumberFormatter("fr_FR", NumberFormatter::SPELLOUT);// et enfin ecrire en chifre
							$w = $f->format($int);
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" >Arr??ter la pr??sente  facture</div><div class="cell" > ?? la somme de :</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.ucfirst($w).' FCFA</b></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" ><b><u>La direction g??n??rale</u></b></div><div class="cell" ></div>
								</div>';
							echo'<div class="row header" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">Nos r??f??rences bancaires</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >Domiciliation:</div><div class="cell" >BANK OF AFRICA</div><div class="cell" ></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >IBAN:</div><div class="cell" ></div><div class="cell"  style="width: 200px">CI93 CI03 2010 1300 6099 2100 0584</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >Banque</div><div class="cell" ></div><div class="cell" >Guichet</div><div class="cell" >Compte</div><div class="cell" >Cl?? RIB</div>
								</div>';
							echo'<div class="row">
								<div class="cell" >CI032</div><div class="cell" ></div><div class="cell" >1013</div><div class="cell" >6099210005</div><div class="cell" >84</div>
								</div>';

							$_SESSION['mdr'] = $mdr;
					}	
					else
					{
					}
	
				?>

				</div>
			</div>
			<div align="center">
				<button type="button" id="impression"  onclick="window.open('proformat_pdf.php', '_blank')" style="width: 250px;  border-radius: 12px;"/>IMPRIMER</button><hr>
				<div align="">
					<form method="post" action=""><!--ce formulaire va pointer sur une ature page qui fera le traitement pour enregistrer la facture proformat en tant que pay??e et aller maintenant a la page facture.php!-->
					<button type="submit" name="buy" style="width: 350px;  border-radius: 12px;">Enregistrer en tant que facture pay??(e)</button><br>
					</form>
					<button style="width: 250px;  border-radius: 12px;"><a href="../views/indexview.php"><i class="fa fa-home" style="font-size: 20px"></i>Acceuil</a></button><br><button style="width: 250px;  border-radius: 12px;"><a href="../register.php"><i class="fa fa-arrow-left" style="font-size: 20px"></i>Retour</a></button>
				</div>
			</div>
		</div>
	</div>


<!--===============================================================================================-->	
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>