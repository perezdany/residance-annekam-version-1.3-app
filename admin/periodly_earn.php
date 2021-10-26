<?php
  session_start();
  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }
  //importer les modules
  include("../Model/confige.php");

  require "../Model/Calculator.php";
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

  <title> Admin | peridoly_earn</title>

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
    function imprimer(divName) {
          var printContents = document.getElementById(divName).innerHTML;    
       var originalContents = document.body.innerHTML;      
       document.body.innerHTML = printContents;     
       window.print();     
       document.body.innerHTML = originalContents;
       }
  </script>


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include('AdminSidebar.txt');?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column bg-gradient-danger">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- //Topbar Search 
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="rechercher par le nom..." aria-label="Search" aria-describedby="basic-addon2" name="nom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="text" class="form-control bg-light border-0 small" placeholder="rechercher par le prénom..." aria-label="Search" aria-describedby="basic-addon2" name="pnom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="go">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>-->
            
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) 
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>-->
              <!-- Dropdown - Messages 
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="nom">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>-->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['pseudo']?></span>
                <img class="img-profile rounded-circle" src="../assets/images/icons/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  listes des Admins
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Deconnexion
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content mais avant faire une bare pour afficher le bilan -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="imprimer('section_to_print');"><i class="fas fa-download fa-sm text-white-50"></i> Générer le rapport</button>
          </div>

        </div>
        <!-- /.container-fluid -->

		<div class="container">

		    <!-- Outer Row -->
		    <div class="row justify-content-center">

		      	<div class="col-xl-10 col-lg-12 col-md-9">

		        	<div class="card o-hidden border-0 shadow-lg my-5">
		        		<div class="card-body p-0">

				    		<!-- Nested Row within Card Body -->
						    <div class="row">
							    <div class="col-lg-12">
							        <div class="p-5">
							          <hr>
							          <div class="text-center">
							            <h1 class="h4 text-gray-900 mb-4">Chiffre d'affaire sur une période</h1>
							          </div>
							          <form class="user" method="post">
							            <div class="form-group row">
  										   	  <div class="col-sm-6 mb-3 mb-sm-0">Date de début:</div>
  							            <div class="col-sm-6">
  							             <input type="date" name="d1" class="form-control form-control-user" required>
  							            </div>
										      </div>
                          <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">Date de fin</div>
                            <div class="col-sm-6">
                             <input type="date" name="d2" class="form-control form-control-user" required>
                            </div>
                          </div>
							            <div class="form-group row">
							              <div class="col-sm-6 mb-3 mb-sm-0"><button type="submit" name="ok" class="btn btn-primary">VALIDER</button></div>
							              <div class="col-sm-6 mb-3 mb-sm-0"><button type="reset" name="reset" class="btn btn-danger">ANNULER</button></div>
							            </div>
                        
							          </form><br>
							        </div>
							    </div>
						    </div>
				   		</div>
					</div>
		    	</div>
		    </div>
		</div>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

          <div class="col-xl-10 col-lg-12 col-md-9">

              <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                <!-- Nested Row within Card Body -->
                <div class="row">

                <div class="container-fluid">
                  <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Ensemble des réservations</h6></div>
                    <div class="card-body">
                      <div class="table-responsive">

                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                        <thead><tr><th><span>Nom des clients</span></th><th>Date de réservation</th><th>Séjour</th><th>Montant de la réservation</th></tr></thead><tbody>
                    
                           <?php
                            //ajout de batiment
                            if(isset($_POST['ok']))
                            {
                              if(isset($_POST['d1']) AND isset($_POST['d2']))
                              {
                                $a = $_POST['d1'];
                                $b = $_POST['d2'];
                              
                                //formater les dates recus
                                $t1 = strtotime($a);//premire date
                                $nt1 = date("Y-m-d", $t1);

                                $t2 = strtotime($b);
                                $nt2 = date("Y-m-d", $t2);//deuxieme date

                                $search = (new calculator())->periodly_earn($nt1, $nt2);
                                while($result = $search->fetch())
                                {
                                    $timestampd = strtotime($result[4]);//recuperation du timestanp de la date donnée
                                    $new_format = date("d/m/Y", $timestampd);//changement du format 
                                    echo'<tr><td>'.$result[5].' '.$result[0].'  '.$result[1].'</td><td>'.$new_format.'</td><td>'.$result[2].'</td><td>'.number_format($result[3], 0, ',', ' ').'</td></tr>';

                                } 

                              }
                            }
                        ?>
                        </tbody>
                    </table>
                      </div>
                    </div>
                             

                    </div> 
                  </div>
                <div class="container-fluid">
                  <div class="card shadow mb-4">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Factures</h6></div>
                    <div class="card-body">
                      <div class="table-responsive">

                          <table class="table table-bordered" id="" width="100%" cellspacing="0">
                            <thead><tr><th>Nom des clients</th><th><span>Date de reservation</span></th><th>Date de règlement</th><th>Mode de règlement</th><th>Montant HT</th><th>Montant TTC</th></tr></thead><tbody>
                             <?php
                                //ajout de batiment
                                if(isset($_POST['ok']))
                                {
                                  if(isset($_POST['d1']) AND isset($_POST['d2']))
                                  {
                                    $a = $_POST['d1'];
                                    $b = $_POST['d2'];
                                  
                                    //formater les dates recus
                                    $t1 = strtotime($a);//premire date
                                    $nt1 = date("Y-m-d", $t1);

                                    $t2 = strtotime($b);
                                    $nt2 = date("Y-m-d", $t2);//deuxieme date

                                     //factures maintenant
                                    $search = $bdd->query("SELECT SQL_NO_CACHE c.nom_clt, c.pnom_clt, r.nb_jr, r.mont_reserv, r.dat_reserv, f.dat_emi, c.title, f.id_fact, p.mod_pay FROM reservation r, facture f, client c, payment p WHERE f.rest_a_pay= 0 AND r.statut='1' AND f.s=1 AND f.id_pay=p.id_pay AND c.id_clt=r.id_clt AND f.id_reserv=r.id_reserv  AND f.id_reserv=r.id_reserv AND r.dat_reserv >= '".$nt1."' AND r.dat_reserv <='".$nt2."' ");

                                     while($result = $search->fetch())
                                      {
                                        $timestampd = strtotime($result[4]);//recuperation du timestanp de la date donnée
                                        $new_format1 = date("d/m/Y", $timestampd);//changement du format  
                                        echo'<tr><td>'.$result[6].' '.$result[0].'  '.$result[1].'</td><td>'.$new_format1.'</td><td>'.$result[5].'</td><td>'.$result[8].'</td><td>'.number_format(round(($result[3]/1.18), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</td><td>'.number_format(round(($result[3]), 0, PHP_ROUND_HALF_DOWN), 0, ',', ' ').'</td></tr>';
                                      }
                                    } 
                                }
                              ?>               
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div> 
                </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

     </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticy-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">SELECT SQL_NO_CACHE SQL_NO_CACHE "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
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



</body>

</html>
