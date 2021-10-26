<?php
  session_start();

  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }

  //charger les modules
  include("../Model/confige.php");

  require "../Model/Customer.php";
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

  <title>Admin | Customers</title>

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


</html>


<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include('AdminSidebar.txt');?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column bg-gradient-danger" >

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search--> 
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="rechercher par le nom..." aria-label="Search" aria-describedby="basic-addon2" name="nom" onkeyup="this.value=this.value.toUpperCase()">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="go">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search" method="post" action="">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="rechercher par le nom..."  aria-label="Search" aria-describedby="basic-addon2" name="nom" onkeyup="this.value=this.value.toUpperCase()">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button" name="go">
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
                <a class="dropdown-item" href="admin.php">
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

        <!-- Begin Page Content -->
        <div class="container-fluid">

           <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="imprimer('section_to_print');"><i class="fas fa-download fa-sm text-white-50"></i> Générer le rapport</button>
          </div>

         
          <?php  
            //recherche de la reservation en fonction du client
              
            $auj = date("Y-m-d");
            if (isset($_POST['go']))
            {
              if(!empty($_POST['nom']))
              {
                $nom = htmlspecialchars($_POST['nom']);
                if(strlen($nom) <= 60)
                {
                  $s = (new Customer())->search_customer($nom, $auj);

                  //recherche de la reservation en fonction du client
                  $cf= (new Customer())->customer_factures($nom, $auj);
                }
                else
                {
                  $er="Désolé, Le nom ne doit pas dépasser 60 caractères";
                }
              }
              else
              {
                $er="veuillez saisir votre recherche!";
              }
            }

            if (isset($er))
            {
               echo"<font color='red'>".$er."</font>";
            }

          ?>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Liste des Clients</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive" id="section_to_print">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr><th>Titre</th><th>Nom</th><th>Prénom(s)</th><th>Téléphone</th><th>Email</th><th>Code Postal</th><th>Action</th></tr>
                  </thead>
                  <tbody>
                    <?php
                    //affichage de tous les clients
                      $client = (new Customer())->all_customer();
                      while($aff = $client->fetch())
                      {
                        echo"<tr><td>".$aff[1]."</td><td> ".$aff[2]."</td><td>".$aff[3]."</td><td>".$aff[4]."</td><td>".$aff[5]."</td><td>".$aff[6]."</td>
                        <td>
                          <button type='button' class='collapsible btn btn-circle bg-gradient-success'><font color='white'><i class='fa fa-angle-down'></i></font></button>
                          <div class='content' style='display:none;'>
                            <button class='btn btn-circle bg-gradient-info'><a href='edit_customer.php?id=".$aff[0]."&amp;n=".$aff[2]."&amp;p=".$aff[3]."&amp;t=".$aff[4]."&amp;mail=".$aff[5]."&amp;ad=".$aff[6]."'><font color='white'><i class='fa fa-edit'></i></font></a>
                            </button>
                            <form method='post' action='../Model/delete.php'><input type='text' value='".$aff[0]."' style='display: none;' name='id'><button class='btn btn-circle bg-gradient-danger' type='submit' name='delcus'><font color='white'><i class='fa fa-trash'></i></font></button>
                            </form>
                          </div>
                        </td></tr>";
                      }
                      
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
