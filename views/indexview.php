<?php
//on prolonge la session
  session_start();
  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }
  //chargerment des modules
  include("../Model/confige.php");

  require "../Model/Appartment.php";
  require "../Model/Calculator.php";
  require "../Model/Database.php";

   
    
  //traitement pour exportation de la bd en sql
  //a chaque semaine il faut exporter la bd
  $d = date('d');
  if($d == 7 OR $d == 14 OR $d == 21 OR $d == 29 OR $d == 30 OR $d == 31)
  {
    $export = (new base_data())->export(); 
    $mess = "L'exportation s'est déroulée avec succès";
  }



  //lorsqu'on clique sur le bouton exporter la base de donnée
  if(isset($_POST['export']))
  {
    
    $export = (new base_data())->export(); 
    $mess = "L'exportation s'est déroulée avec succès";
   
  }
  else
  {
    
  }

?>
<!DOCTYPE html>
<html lang="en" >
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico"/>
  <title>Admin | Acceuil</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

   <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><!--POUR LE POPUP-->
  <script type="text/javascript">
    $(document).ready(function() {
     $("#fond,#popup").css({"display":"block"}); // on affiche les div
     $("#fond,#close").click(function(){
    $("#fond,#popup").css({"display":"none"}); // si l'utilisateur clique sur le fond opaque ou le bouton, on ferme le tout
     });
  });

     setTimeout(
       function(){
           $("#fond,#popup").css({"display":"block"}); // on affiche les div
           $("#fond,#close").click(function(){
            $("#fond,#popup").css({"display":"none"}); // si l'utilisateur clique sur le fond opaque ou le bouton, on ferme le tout
           });
           setTimeout(function(){
                $("#fond,#popup").css({"display":"none"});
               }, 5000);

    }, 5000);
  </script>


</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexview.php">
        <div class="sidebar-brand-icon">
          
        </div>
        <div class="sidebar-brand-text mx-3">RESIDENCES <sup>ANNEKAM</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="indexview.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Recettes</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Gestions internes</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gestions internes:</h6>
            <a class="collapse-item" href="../admin/table.php">Tableau de bord(mensuel)</a>
            <a class="collapse-item" href="../admin/reserv_history.php">Historique des réservations</a>
            <a class="collapse-item" href="../admin/recoveries.php">Entretien d'appartements</a>
            <a class="collapse-item" href="../admin/month_recoveries.php">Entretien Mensuels</a>
            <a class="collapse-item" href="../admin/appartment.php">Gestion d'appartements</a>
            <a class="collapse-item" href="../admin/batiment.php">Gestion de batiments</a>
            <a class="collapse-item" href="../admin/bed.php">Gestion de lits</a>
            <a class="collapse-item" href="../admin/admin.php">Gestion d'admin</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Gestions extrenes</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Gestions extrenes:</h6>
            <a class="collapse-item" href="../admin/customer.php">Clients</a>
            <a class="collapse-item" href="../admin/reservation.php">Réservations</a>
            <a class="collapse-item" href="../admin/fact.php">factures</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Actions
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Activités</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Activités:</h6>
            <?php 
                $q = $bdd->query("SELECT type FROM admin WHERE pseudo='".$_SESSION['pseudo']."'");
                while($type = $q->fetch())
                {

                  if($type[0]=="standar")//verifier le type d'admin pour afficher les données correspondantes
                  {
                   
                  }
                  else
                  {
                    echo'<a class="collapse-item" href="../admin/periodly_earn.php">Chiffre d\'affaire périodique</a>';
                  }
                }


            ?>
           
            <a class="collapse-item" href="../register.php">Ajouter une réservation</a>
            <form method="post" action="../index.php"><button type="submit" style='background: transparent; border: none' class="collapse-item" name="logout">Connexion</button></form>
            <!--<a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>-->
          </div>
        </div>
      </li>

      <!-- //Nav Item - Charts 
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>-->

      <!-- //Nav Item - Tables 
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>-->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column bg-gradient-danger">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <form method="post">
            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type='submit' name="export"><i class="fas fa-download fa-sm text-white-50"></i>Exporter la base de données(.sql)</button>
            <?php
              if(isset ($mess))
              {
                echo $mess;
              }
            ?>
          </form>
          <div id="fond"></div>
          <div id="popup">
           <div id="close"></div>
          </div>
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

       
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="search">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['pseudo']?></span>
                  <img class="img-profile rounded-circle" src="../assets/images/icons/user.png">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="../admin/admin.php">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    listes des Admins
                  </a>
                  <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Deconnexion
                    </a>
                </div>
              </li>

          </ul>


        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-100">Recettes</h1>
             <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="imprimer('section_to_print');"><i class="fas fa-download fa-sm text-white-50" style=<?php $q = $bdd->query("SELECT type FROM admin WHERE pseudo='".$_SESSION['pseudo']."'");while($type = $q->fetch()){if($type[0]=="standar"){
                echo'style=display:none';}}?> ></i> Générer le rapport</button>
            
          </div>
          <!-- Content Row -->
          <?php
            //on va faire une vérfication si l'admin est un admin standar ne pas afficher les chiffres d'affaires
            $q = $bdd->query("SELECT type FROM admin WHERE pseudo='".$_SESSION['pseudo']."'");
            while($type = $q->fetch())
            {
              if($type[0]=="standar")
              {
                echo'<div class="row" id="section_to_print"> </div>';
              }
               if($type[0]=="super")
              {
                echo'<div class="row" id="section_to_print">';

                    // Earnings (Monthly) Card Example 
                    echo'<div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Chiffre d\'affaire (Mensuel)</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">';

                                  $month = (new calculator())->earn_monthly();
                                  echo number_format($month, 0, ',', ' ')."  FCFA";
                          echo'</div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';

                    //Earnings (Monthly) Card Example 
                    echo'<div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Chiffre d\'affaire (Annuel)</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">';
                                  $annualy = (new calculator())->earn_annualy();
                                  echo number_format($annualy, 0, ',', ' ')."  FCFA";
                              echo'</div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';

                    //Earnings (Monthly) Card Example -->
                    echo'<div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dépenses</div>
                              <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">';
                                  
                                      $outlay = (new calculator())->outlay();
                                      echo number_format($outlay, 0, ',', ' ')."  FCFA";
                                  
                                  echo'</div>
                                </div>
                              </div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';

                    //Pending Requests Card Example
                   echo' <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Réservations en cours</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">';
                                  $n = (new calculator())->waiting_reservation();
                                      echo $n;
                              echo'</div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
              }
            }
          ?>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Appartements disponibles</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>APPARTEMENT</th><th>DESIGNATION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      //affichage des batiments
                      $see = (new appartment())->appdispo();
                    ?>
                  </tbody> 
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

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
          <h5 class="modal-title" id="exampleModalLabel">Voulez- vous vous déconnecter?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Cliquez sur "Deconnexion" si vous êtes prêt à quitter la session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
           <form method="post" action="../index.php"><button type="submit" class="btn btn-primary" name="logout">Déconnexion</button></form>
        </div>
      </div>
    </div>
  </div>


  <script language="javascript">
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    } 
  </script>



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
           





             

            
