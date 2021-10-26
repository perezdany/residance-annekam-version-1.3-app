<?php 
  session_start();

  require'../Model/Appartment.php';
  function old_table()
  {
  	if(isset($_POST['go']))
	{
		
		$month = $_POST['month'];
		$year = $_POST['year'];
		$num_mois = date('n'); // numero du mois
		$num_an = date('Y'); //l'an
		
		if(intval($num_an) < intval($year))//l'annee la est superieur a l'année
		{
			$error='Désolé! Tableau introuvable!';
			echo'<font color="red" ><h4>'.$error.'</h4></font>';
		}
		else
		{
			$_SESSION['month'] = intval($month);
			$_SESSION['year'] = intval($year);

			header("location:old_table.php");
			//echo'<font color="green"><h4>Cliquer sur ce bouton <a href="old_table.php"><button class="btn-primary" type="" style="border-radius: 10px; width:100px">voir</button></a> pour voir le tableau:</h4></font>';
		}
		
	}
	
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>RESIDENCES ANNEKAN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="../assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	
<!--===============================================================================================-->

<style type="text/css">
	/* unvisited link */
a:link {
  color: #636465;
  text-decoration: none;
}
/* visited link */
a:visited {
  color: #636465;
}

/* mouse over link */
a:hover {
  color: hotpink;
}

/* selected link */
a:active {
  color: #636465;
}
</style>

<!--code javascript pour imprimer-->
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
<body style="background: #d1d1d1;">
	
	<div class="limiter" style="background: #d1d1d1;">

		<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="window.open('table_pdf.php');"><i class="fa fa-download fa-sm text-white-50"></i> Générer le rapport</button>
		<div class="" style="background: #d1d1d1; width:1600px;">

			<div class="" style="background: #d1d1d1;">
				<div align="center" class="container">
						<form  action="table.php" method="post" class="user-form">
								<?php	
									old_table();
								?>

								<u><b><h4>Rechercher un tableau</h4></b></u>
								<label>Mois:</label>
								<select class="form-control" style="width:200px" name="month">
									<?php

										//tableau pour les mois
										$mois = ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'];
										for($a = 0; $a<12; $a++)
										{
											echo'<option value="'.$a.'">'.$mois[$a].'</option>';
										}
									?>
								</select>
								<label>Année:</label>
								<select class="form-control" style="width:200px" name="year">
									<?php
										
										for($a = 2020; $a<=2030; $a++)
										{
											echo'<option value="'.$a.'">'.$a.'</option>';
										}
									?>
								</select>
							
							<br>
							<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit" style="" name="go">AFFICHER</button>
						</form>
						
					
				</div><br>
				<div class="table100 ver1 m-b-110" style=" padding-left:5px">
					<table data-vertable="ver1" style="width: 600px;  padding-left: 15px">
						<thead>
							<tr class="row100 head">
								
								<th class="column100 column1" data-column="column1" style="width: 200px;" colspan="3" align="center "><h5><u><b>TABLEAU DE BORD MENSUEL,<?php
								//tabelau de bord
								$num_mois = date('n'); // numero du mois
								$num_an = date('Y'); //l'an
								//créer un tableau de mois et en fonction du numéro ecrire le mois
								$mois = ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'];
								echo "  ".$mois[($num_mois-1)]." ".$num_an;
								?></b></u></h5></th>
							</tr>
						</thead>
						
						<tbody>
							
							<tr class="row100" >
								<td class="column100 column1" data-column="column1" style="width: 200px;"><b>RETOUR:</b><button style="background: transparent; border: none"><a href="../views/indexview.php"><i class="fa fa-home" style="font-size: 30px"></i></a></button></td>
								<td class="column100 column2" data-column="column2" style="width: 200px;"><b><u>LEGENDE:</u> Ocuppé</b></td>
								<td class="column100 column2" data-column="column2" style="width: 100px; background-color:#ee7a7a;"></td>
							</tr>

							
						</tbody>
					</table><br>
					
				</div>
				<!--<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="imprimer('section_to_print');"><i class="fa fa-download fa-sm text-white-50" ></i> Générer le rapport</button>-->
				<div class="table100 ver2">
					<table data-vertable="ver2 m-b-110" id="section_to_print">

						<?php
						 	
							$t = new appartment();
							$disp = $t->table();
						?>
					</table>
				</div>
				
				
			</div>
		</div>


	 
		
	</div>


	

<!--===============================================================================================-->	
	<script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/bootstrap/js/popper.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/js/main.js"></script>

</body>
</html>