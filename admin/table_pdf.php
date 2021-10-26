<?php
  session_start();

  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }
  //on charge les modules
  include("../Model/confige.php");

  require "../Model/Reservation.php";
  require "../Model/delete.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico"/>

  <title> Dashboard </title>

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../assets/css/tablestyle.css">
  <link rel="stylesheet" href="../assets/css/style.css">


  <!--code javascript pour imprimer-->
  <script>
   
  </script>


</head>

<body id="page-top">

   <div class="row">

      <!-- Main Content -->
      <div style="width:100%" >
      	  <!-- DataTales Example -->
          <div class="card shadow mb-12">
            
            <div class="card-body col-12">
              <div class="card-header py-6">
              <h6 class="m-0 font-weight-bold text-primary"><?php $mois = ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE']; echo 'RESERVATIONS: '.$mois[($_SESSION['num_mois']-1)].' '.$_SESSION['num_an']; ?></h6>
            </div>
              <div class="table-responsive col-12" id="section_to_print">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
	                <thead>
	                    <tr>
	                      <th>Nom et Prénoms</th><th>Contacts</th><th><span>Appartement</span></th><th><span>Date</span><th><span>Date d'arrivée</span><th><span>Jour</span></th><th><span>Montant</span></th>
	                    </tr>
	                </thead>
	                <tbody>
	                  <?php
	                  if(isset($_SESSION['num_an']) AND isset($_SESSION['num_mois']) AND isset($_SESSION['number']))
      							{
      								unset($_SESSION['month']);
      								unset($_SESSION['year']);
      								
      							 	//faire les dates de debut et de fin
      							 	$dd = $_SESSION['num_an']."-".$_SESSION['num_mois'].'-01';
      								$df = $_SESSION['num_an']."-".$_SESSION['num_mois'].'-'.$_SESSION['number'];
      								//montant total
      								$tot = 0;

      								//on ecrit le code pour afficher les mouvements 
      								$reservation = $bdd->query("SELECT c.nom_clt, c.pnom_clt, c.tel, a.lib_appart, r.dat_reserv, r.dat_arriv, r.nb_jr, r.mont_reserv FROM client c, appartement a, reservation r WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.statut=1  AND r.dat_arriv BETWEEN '".$dd."' AND '".$df."'");
      								
      								//les lignes
      								while($fetch = $reservation->fetch())
      								{
      									$timestamp1 = strtotime($fetch[4]); //recupération du timestamp de la date donnée
      									$newdate1 = date("d/m/Y", $timestamp1);//conversion2(en francais)
      									$timestamp2 = strtotime($fetch[5]); //recupération du timestamp de la date donnée
      									$newdate2 = date("d/m/Y", $timestamp2);//conversion2(en francais)
      									echo'<tr><td>'.$fetch[0].' '.$fetch[1].'</td><td>'.$fetch[2].'</td><td>'.$fetch[3].'</td><td>'.$newdate1.'</td><td>'.$newdate2.'</td><td>'.$fetch[6].'</td><td>'.number_format($fetch[7], 0, ',', ' ').'</td></tr>';

      									$tot +=  $fetch[7];
      								}
      								echo'<tr><th colspan="3">TOTAL</th><td colspan="4">'.number_format($tot, 0, ',', ' ').'</td></tr>';
      							}
      							else
      							{
      								echo'Oups une erreur est survenue<a href="table.php">retour</a>';
      							}	
	                  	//affichage des apparts
	             
                     
	                  ?>
	                </tbody>
			          </table>
              </div>
            </div>
          </div>

     </div>
      <!-- End of Main Content -->


    </div>


  
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>

<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>

</body>

</html>

