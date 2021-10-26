<?php
	session_start();
	include("../Model/confige.php");
    include("../Model/ChiffresEnLettres.php");
    //include("../Model/object.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Info | reservations</title>
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
						
		            	foreach ($_GET as $key => $value) {
						    $sGET[$key]=htmlentities($value, ENT_QUOTES);
						}
						 
						foreach ($_POST as $key => $value) {
						    $sPOST[$key]=htmlentities($value, ENT_QUOTES);
						}

						//avec les sessions
						if(isset( $_GET['id']) AND isset($_GET['datres']) AND isset($_GET['hres']) AND isset($_GET['j'])  AND isset($_GET['nc']) AND isset($_GET['pnc']) AND isset($_GET['s']) AND isset($_GET['a']) AND isset( $_GET['m']) AND isset($_GET['datar']) AND isset( $_GET['datdep']) AND isset($_GET['ob']))
						{
							$date = date("d/m/Y");
							echo'<div class="row header">
							<div class="cell">RESERVATION</div><div class="cell"></div><div class="cell"></div><div class="cell">Abidjan le '.$date.'</div><div class="cell"></div>
							</div>';
							echo'<div class="row">
								<div class="cell" >RESERVATION N°    '.$_GET['id'].'</div><div class="cell" ></div><div class="cell"></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" >CLIENT:<b> '.$_GET['nc'].'  </b></div><div class="cell" ><b>'.$_GET['pnc'].'</b></div><div class="cell"></div>
								</div>';

							echo'<div class="row">
								<div class="cell"><b>Objet de la réservation:</b></div><div class="cell" style="width:250px">'.$_GET['ob'].'</div><div class="cell" ></div><div class="cell" ><b>Appartement :</b></div><div class="cell" >'.$_GET['a'].'</div>
								</div>';

							echo'<div class="row">
							<div class="cell"><b>Date de la réservation:</b></div><div class="cell">'.$_GET['datres'].'</div><div class="cell"></div><div class="cell"><b>Heure de la réservation:</b></div><div class="cell">'.$_GET['hres'].'</div><div class="cell"></div>
							</div>';
							echo'<div class="row">
							<div class="cell"><b>Durée du séjour:</b></div><div class="cell">'.$_GET['j'].'  jour(s)</div><div class="cell"></div><div class="cell"></div><div class="cell"></div>
							</div>';
							echo'<div class="row">
								<div class="cell" ><b>Date d\'arrivée:</b></div><div class="cell" >'.$_GET['datar'].'</div><div class="cell" ><b>Date de départ:</b></div><div class="cell" >'.$_GET['datdep'].'</div><div class="cell" ></div>
								</div>';
							echo'<div class="row">
								<div class="cell" ><b>MONTANT DE LA RESERVATION:</b></div><div class="cell" ></div><div class="cell" >'.number_format($_GET['m'], 0, ',', ' ').'</div><div class="cell" ></div><div class="cell" ></div>
								</div>';//montant de la reservation
							// verification pour dire si la réservation est soldée ou pas
							 if(intval($_GET['s'] == 0))
				            {
				            	echo'<div class="row">
								<div class="cell" ></div><div class="cell" ><b>RESERVATION </b></div><div class="cell" ><b>NON SOLDE(E)</b></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
				            }
				            else
				            {
				            	echo'<div class="row">
								<div class="cell" ></div><div class="cell" ></div><div class="cell" ><b>RESERVATION SOLDE(E)</b></div><div class="cell" ></div><div class="cell" ></div>
								</div>';
				            }


						}
						else
						{
						}
						//il faut créer des sessions pour aller sur l'autre onglet pour afficher l'etat d'impression
						$_SESSION['id']=$_GET['id'];
						$_SESSION['datres']=$_GET['datres'];
						$_SESSION['hres']=$_GET['hres'];
						$_SESSION['j']=$_GET['j'];
						$_SESSION['nc']=$_GET['nc'];  
						$_SESSION['pnc']=$_GET['pnc'];
						$_SESSION['s']=$_GET['s'];
						$_SESSION['a']=$_GET['a'];
						$_SESSION['m']=$_GET['m'];
						$_SESSION['datar']=$_GET['datar'];
						$_SESSION['datdep']=$_GET['datdep'];
						$_SESSION['ob']=$_GET['ob'];


					?>

				</div>
				<br>
			
			</div>
				<div align="center">
					<button id="impression" onclick="window.open('impreservation_pdf.php', '_blank')" style="width: 250px;  border-radius: 12px;">IMPRIMER</button><hr>
					<button style="width: 250px;  border-radius: 12px;"><a href="../views/indexview.php"><i class="fa fa-home" style="font-size: 20px"></i>Acceuil</a></button><br><button style="width: 250px;  border-radius: 12px;"><a href="../admin/reservation.php"><i class="fa fa-arrow-left" style="font-size: 20px"></i>Retour</a></button>
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

