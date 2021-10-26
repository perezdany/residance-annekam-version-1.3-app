<?php
	session_start();
	include("../Model/confige.php");
    //include("../phps/ChiffresEnLettres.php");
    //include("../phps/object.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Facture</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>	
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
<!--print css
<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />-->
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
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">

				<div class="table" id="sectionAimprimer">
					<?php
						
						//avec les sessions
					 	
						if(isset( $_SESSION['nom']) AND isset($_SESSION['pnom']) AND isset($_SESSION['date']) AND isset($_SESSION['fact']) AND isset($_SESSION['pay']) AND isset($_SESSION['rest']))
						{
							$date = date("d/m/Y");
							echo'<div class="row header" style="font-weight:bold; color: #292929;">
							<div class="cell" style="font-weight:bold; color: #292929;">Facture N°'.$_SESSION['fact'].'</div><div class="cell"></div><div class="cell"></div><div class="cell" style="font-weight:bold; color: #292929;">Abidjan le '.$date.'</div><div class="cell"></div>
							</div>';
							
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">CLIENT: '.$_SESSION['nom'].'  '.$_SESSION['pnom'].'</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" style="font-weight:bold; color: #292929;"><u>Objet</u>:</div><div class="cell"  style="font-size:9.5px">Location d\'appartement meublé</div><div class="cell" ></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row header" style="font-weight:bold; color: #292929;">
								<div class="cell" style="font-weight:bold; color: #292929;">DESIGNATION</div>
								<div class="cell" style="font-weight:bold; color: #292929;">UNITE</div>
								<div class="cell" style="font-weight:bold; color: #292929;">QUANTITE</div>
								<div class="cell"  style="font-weight:bold; color: #292929;">Prix Unitaire</div>
								<div class="cell" style="font-weight:bold; color: #292929;">TOTAL</div>
								</div>';
								
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" style="font-weight:bold; color: #292929;">'.$_SESSION['desig'].'</div>
								<div class="cell" style="font-weight:bold; color: #292929;">U</div>
								<div class="cell" style="font-weight:bold; color: #292929;">'.$_SESSION['j'].' JOURS</div>
								<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round(($_SESSION['p1']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>
								';
							echo'<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round(($_SESSION['montant']/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>';
							echo'</div>';
							
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">TVA 18%</div>
							<div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format(round(($_SESSION['montant'])*0.18, 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</b></div>
								</div>';
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">MONTANT TOTAL TTC</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['montant'], 0, ',', ' ').'</b></div>
								</div>';//montant de la reservation
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">ACOMPTE</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['pay'], 0, ',', ' ').'</b></div>
								</div>';//ce qu'il a payé
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" style="font-weight:bold; color: #292929;">RESTE A PAYER</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.number_format($_SESSION['rest'], 0, ',', ' ').'</b></div>
								</div>';
							//verifier si la facture est payée
							/*$verif = $bdd->query('SELECT SQL_NO_CACHE s FROM facture WHERE id_fact="'.$_SESSION['fact'].'"');
							while($obtenir = $verif->fetch())
							{
								if(intval($obtenir[0]) == 1)
								{
									echo'<div class="row">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" >Reste à Payer</div><div class="cell" >0 FCFA</div>
								</div>';
								}
								else
								{

								}
							}*/
							
							//$lettre=new ChiffreEnLettre();
							//$l = $lettre->Conversion($_SESSION['pay']);
							//Formater de sorte a afcciher en lettre
							$fmt = new NumberFormatter( 'en_EN', NumberFormatter::DECIMAL ); //créer un format et comme notre nombre est décimal donc décimal
							$num = $fmt->parse($_SESSION['pay']);
							$int = $fmt->parse($num, NumberFormatter::TYPE_INT32);//ensuite rendre entier
							$f = new NumberFormatter("fr_FR", NumberFormatter::SPELLOUT);// et enfin ecrire en chifre
							$w = $f->format($int);
							echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" >Arrêter la présente  facture</div><div class="cell" > à la somme de :</div><div class="cell" style="font-weight:bold; color: #292929;"><b>'.ucfirst($w).' FCFA</b></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							$pay_query = $bdd->query('SELECT mod_pay FROM payment WHERE id_pay="'.$_SESSION['pay_mod'].'"');
							while($pay_mod = $pay_query->fetch())
							{
								echo'<div class="row" style="font-weight:bold; color: #292929;">
								<div class="cell" >Facture réglée: </div><div class="cell" >'.$pay_mod[0].'</div><div class="cell" style="font-weight:bold; color: #292929;"></b></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
								$_SESSION['lib_modp'] = $pay_mod[0];
							}
							
							echo'<div class="row">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ></div><div class="cell" ><b><u>La Direction Générale</u></b></div><div class="cell" ></div>
								</div>';
							echo'<div class="row header" style="font-weight:bold">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" >Nos références bancaires</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >Domiciliation:</div><div class="cell" >BANK OF AFRICA</div><div class="cell" ></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >IBAN:</div><div class="cell" ></div><div class="cell"  style="width: 200px">CI93 CI03 2010 1300 6099 2100 0584</div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" >Banque</div><div class="cell" ></div><div class="cell" >Guichet</div><div class="cell" >Compte</div><div class="cell" >Clé RIB</div>
								</div>';
							echo'<div class="row">
								<div class="cell" >CI032</div><div class="cell" ></div><div class="cell" >1013</div><div class="cell" >6099210005</div><div class="cell" >84</div>
								</div>';
					
						}
						else
						{
						}
							
					?>

				</div>
				<br>
			</div>
			<div align="center">
				<button id="impression" onclick="window.open('fact_pdf.php', '_blank')" style="width: 250px;  border-radius: 12px;">IMPRIMER</button><hr>
				<div>
					<button style="width: 250px;  border-radius: 12px;"><a href="../views/indexview.php"><i class="fa fa-home" style="font-size: 20px"></i>Acceuil</a></button><br><button style="width: 250px;  border-radius: 12px;"><a href="../admin/customer.php"><i class="fa fa-arrow-left" style="font-size: 20px"></i>Retour</a></button>
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