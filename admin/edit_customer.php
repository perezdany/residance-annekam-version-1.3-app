<?php 
  session_start();
  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }
  //Models
  include("../Model/confige.php");
  include("../Model/Customer.php");
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

  <title>Modify - customer</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body class="bg-gradient-danger">
 

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
          <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-12">
              <!--formulaire pour la modifiaction de reservation-->
              <div class="p-5">
                <hr/>
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Modification de clients</h1>
                </div>
               
                <form class="user" method="post" action="">
                  <?php
                    //reservations
                    if(isset($_GET['id']) AND isset($_GET['n']) AND isset($_GET['p']) AND isset($_GET['t']) AND isset($_GET['mail']) AND isset($_GET['ad']))
                    {

                      $res =  $bdd->query("SELECT SQL_NO_CACHE * FROM client WHERE id_clt='".$_GET['id']."' ");
                      $elmt = $res->fetch();
                      echo'<div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          Nom:
                          <input type="text" name="nom" value="'.$_GET['n'].'" class="form-control form-control-user" id="exampleFirstName" onkeyup="this.value=this.value.toUpperCase()">
                        </div>
                        <div class="col-sm-6">
                        Prénom(s):
                        <input type="text" name="pnom" value="'.$_GET['p'].'"class="form-control form-control-user" id="exampleLastName" onkeyup="this.value=this.value.toUpperCase()">
                        </div>
                      </div>';

                      echo'<div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          Téléphone:
                          <input type="text" value="'.$_GET['t'].'" class="form-control form-control-user" name="tel">
                        </div>
                        <div class="col-sm-6">
                        Adresse Email:
                        <input type="text" value="'.$_GET['mail'].'"class="form-control form-control-user" name="mail">
                        </div>
                      </div>';
                      

                      echo'<div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          Code postal:
                          <input type="text" value="'.$_GET['ad'].'" class="form-control form-control-user" name="ad" >
                        </div>
                        <div class="col-sm-6">
                       
                        </div>
                      </div>';                    

                      echo'<div class="form-group row">';
                        echo'<div class="col-sm-6 mb-3 mb-sm-0">
                          <button type="submit" name="mod" class="btn btn-primary">MODIFIER</button>
                        </div>';
                        echo'<div class="col-sm-6">
                          <button type="reset" name="reset" class="btn btn-danger">ANNULER</button>
                        </div>';
                      echo'</div>';
                       

                          
                      //traitement pour la modification
                      if(isset($_POST['mod']))
                      {
                        
                        //requete pour la modification
                        if(isset($_POST['nom']) OR isset($_POST['pnom']) OR isset($_POST['tel']) OR isset($_POST['mail']) AND isset($_POST['ad']))
                        {
                          $nom = htmlspecialchars(($_POST['nom']));
                          $prenom = htmlspecialchars(($_POST['pnom']));
                          $tel = htmlspecialchars(($_POST['tel']));
                          $mail = htmlspecialchars(($_POST['mail']));
                          $ad = htmlspecialchars(($_POST['ad']));
                          
                          //modificaiton des infos du client
                          $mod = (new customer())->mod_customer($nom, $prenom, $tel, $mail, $ad, $_GET['id']);
                          echo'<font color="green">Modification effectuée avec succès!</font>';

                        }
                       
                      }

                    }
               
                ?>
                </form>
              </div><hr>
              <div class="text-center">
                <a class="small" href="customer.php"><font style="font-size: 20px">Retour en arrière</font></a>
              </div>
            </div>
          </div>
        </div>
    

          <!-- Nested Row within Card Body -->
       

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