<?php
  include("Model/confige.php");
  //destruction complète de la session
  if(isset($_POST['logout']))//verifier si le ga a cliqué sur deconnexion
  {
    // Démarrage ou restauration de la session
    session_start();
    // Réinitialisation du tableau de session
    // On le vide intégralement
    $_SESSION = array();
    // Destruction de la session
    session_destroy();
    // Destruction du tableau de session
    unset($_SESSION);
  }
//tratiement pour la connexion
  
  if (isset($_POST['go']))//si on on a cliqué sur le boutton
  {
    $pseudo = htmlspecialchars($_POST['ps']);
    $mdp = htmlspecialchars($_POST['mdp']);
    if (!empty($_POST['ps']) || !empty($_POST['mpd']))
    {
      $query = $bdd->prepare("SELECT SQL_NO_CACHE * FROM admin WHERE pseudo =? AND mdp =?");
      $query->execute(array($pseudo, $mdp));
      $f = $query->fetchAll();
      $n = count($f);
      if($n == 1)
      {
        session_start();
        $_SESSION['pseudo'] = $pseudo;
        header("location:views/indexview.php");
        exit();
      }
      else
      {
        $er="<font color='red'>Désolé, utilisateur non existant<font/>";
      }
    }
    else
    {
      $er="<font color='red'>veuillez renseigner tous les champs<font/>";
    }
  }
                    

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>

  <title>Admin | Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-image: url('img/annekam2.jpg'); background-repeat: inherit;">
  
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5"  style="background-color: #d6cdcd">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6" style="background-color: #d6cdcd">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenue!</h1>
                  </div>
                  <form class="user" method="post" action="">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Entrer le pseudo..."  name="ps" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mot de Passe" name="mdp" required>
                    </div>
                    <input name="go" type="submit" class="btn btn-primary" value="connexion">
                     
                    <hr>
                    <?php
                      if(isset($er))
                      {
                        echo $er;
                      }
                    ?>
                  </form>
                  <hr>
                  <div class="text-center">
                    <font color="black">Mot de passe oublié?</font>
                  </div>
                  <div class="text-center">
                    <a class="small" href="admin/add_admin.php">Créer un compte admin!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
