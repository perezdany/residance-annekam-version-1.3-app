<?php 
  session_start();
  if(empty($_SESSION['pseudo'])) 
  {
    // Si inexistante ou nulle, on redirige vers le formulaire de login
    header('Location:../index.php');
    exit();
  }

  //chargement des modules
  include("../Model/confige.php");
  include("../Model/Reservation.php");
  include("../Model/Facture.php");
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

  <title>buy - reservation</title>

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
                <?php
                  //voir si sa reservation est soldée et si ce n'est pas le cas, afficher le formulaire de facture

                  $voir = $bdd->query("SELECT SQL_NO_CACHE f.id_fact FROM facture f, reservation r WHERE r.id_reserv= f.id_reserv AND s='1' AND f.rest_a_pay=0 AND r.id_reserv='". $_GET['id']."'");
                  $c = $voir->fetchAll(); 
                  $n = count($c);
                  if($n == 1)//soldée
                  {
                    echo'reservation soldée!';
                  }  
                  if($n == 0)//reservation non soldée
                  {
                    
                    //on recupere les elemnts aussi de la derniere facture payée
                    echo'<hr/><div class="text-center"><h1 class="h4 text-gray-900 mb-4">Payment de la réservation</h1></div>';
                    $voirm = $bdd->query("SELECT SQL_NO_CACHE r.id_appart, r.nb_adlt, r.nb_enf, r.dat_arriv, r.nb_jr, c.nom_clt, c.pnom_clt, a.lib_appart, r.mont_reserv, f.rest_a_pay FROM reservation r, appartement a, client c, facture f WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND f.id_reserv=r.id_reserv AND r.id_clt='".$_GET['clt']."' AND r.id_reserv='".$_GET['id']."' ORDER BY f.hr_emi DESC LIMIT 1");
                    $djai = $voirm->fetch();

                    echo'<form class="user" method="post">';
                    echo'<div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          RESERVATION N°:<input type="text" value="'.$_GET['id'].'" name="nom" value="'.$djai[5].'" class="form-control form-control-user" id="exampleFirstName" disabled="disabled">
                        </div>
                        <div class="col-sm-6">
                        MONTANT DE LA RESERVATION N°:</label><input type="text" value="'.$djai[8].'" name="pnom"class="form-control form-control-user" id="exampleLastName" disabled="disabled">
                        </div>
                    </div>';
                    
                    echo'<div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0"><br>
                            <input type="text" name="m" class="form-control form-control-user" required placeholder="Montant A Payer:">
                          </div>';
                   
                    echo'<div class="col-sm-6">
                            MONTANT RESTANT DE LA RESERVATION<input type="text" class="form-control form-control-user" value="'.$djai[9].'" disabled="disabled">
                          </div>';
                   
                    echo'</div>';
                    echo'<div class="form-group row">
                          <div class="col-sm-8 mb-3 mb-sm-0"><br>
                              Mode de payement:';
                               //on afficher les différents mode de payement de la  base
                              $query = $bdd->query("SELECT * FROM payment");
                              echo'<br><select  class="form-control" name="pay_mod" style="width:200px">';
                              while($pay = $query->fetch())
                              {
                                echo'<option value="'.$pay[0].'">'.$pay[1].'</option>';
                              }
                              echo'</select>
                          </div>';
                   
                    echo'<div class="col-sm-4">';
                       
                              
                    echo'</div>';
                   
                    echo'</div>';
                    echo'<button type="submit" name="fact" class="btn btn-primary">PAYER</button>';

                    //traitement pour generer la facture
                    if(isset($_POST['fact']))
                    {
                      if(!empty($_POST['m']))
                      {
                        $arg = intval($_POST['m']);
                        $_SESSION['pay'] = $arg;
                        $pay_mod = $_POST['pay_mod'];
                        $_SESSION['pay_mod'] = $pay_mod;
                        $idfact = "F".rand(0,10000);//id de facture
                        $_SESSION['fact'] = $idfact;
                        $da = date('Y-m-d');
                        $_SESSION['date'] = $da;
                        $hr = date("H:i:s");

                        //Selectionner le montant qui reste a payer de la derniere facture reglée
                        $montr = $bdd->query("SELECT SQL_NO_CACHE f.rest_a_pay FROM facture f, reservation r WHERE f.id_reserv=r.id_reserv AND r.id_reserv='".$_GET['id']."' AND f.s='1' ORDER BY f.hr_emi DESC, f.dat_emi DESC LIMIT 1");
                        $observ = $montr->fetchAll();
                        $compte = count($observ);

                        if($compte == 0)//ca veut dire c'est sa premiere facture qu'il doit regler
                        {
                          //c'est que là on va prendre le montant qui est dans la reservation vu que le client fait son premier payement
                          $montreserv = $bdd->query("SELECT SQL_NO_CACHE mont_reserv FROM reservation  WHERE id_reserv='".$_GET['id']."' ");
                          $mont = $montreserv->fetch();
                          $rest = intval($mont[0]) - $arg;//faire la soustraction
                          $_SESSION['rest'] = $rest;
                          if($rest < 0)
                          {
                            echo'<font color="red"> Montant trop élevé! Veuillez entrer un montant plus petit que le précédent</font>';
                          }
                          else
                          {
                            //insertion (facture payée)
                            
                            $insert = (new facture())->insertfact($idfact, $arg, $_GET['id'], $_SESSION['date'], $rest, $hr, $pay_mod);

                            //mise a jour de la table reservation
                            
                            if($rest == 0)
                            {
                              $maj = (new reservation())->update_statut($_GET['id']);
                            }
                            else
                            {

                            }
                             //les elements pour la facture

                            //les tarifs et le nom de l'appart
                            $choisi = $bdd->query("SELECT SQL_NO_CACHE a.tar_jour, a.tar_mois, a.lib_appart FROM appartement a, reservation r WHERE a.id_appart=r.id_appart AND r.id_reserv='".$_GET['id']."' ");
                            $tarifs = $choisi->fetch();
                            $_SESSION['desig'] = $tarifs[2];
                            $_SESSION['p1'] = $tarifs[0];

                            //nom et prenoms du client
                            $cl = $bdd->query("SELECT SQL_NO_CACHE nom_clt, pnom_clt FROM client WHERE id_clt='".$_GET['clt']."' ");
                            $clt = $cl->fetch();
                            $_SESSION['nom'] = $clt[0];
                            $_SESSION['pnom'] = $clt[1];

                            //nbre de jour  dans reservation
                            $nb = $bdd->query("SELECT SQL_NO_CACHE mont_reserv, nb_jr  FROM reservation WHERE id_reserv='".$_GET['id']."'");
                            $o = $nb->fetch();
                            $_SESSION['montant'] = $o[0];
                            $_SESSION['j'] = $o[1];
                            $_SESSION['reserv'] = $_GET['id'];
                           
                            echo'<font color="green">Action effectuée; <a href="../facture/facture.php" >Imprimer facture</a></font>';
                          }
                        }
                        else//y a une facture
                        {
                          
                          //voir si la facture existe a l'instant t
                          $verif = $bdd->query("SELECT SQL_NO_CACHE f.mont_pay FROM facture f, reservation r WHERE f.id_reserv=r.id_reserv AND f.id_fact='".$idfact."'");
                          $see = $verif->fetchAll();
                          $ok = count($see);

                          if($ok == 0)//la facture n'existe pas
                          {
                            //voir si le montant qu'il a entré ne depasse PAS le rest a payer de la dernière facture
                            $ver = $bdd->query("SELECT SQL_NO_CACHE f.rest_a_pay FROM facture f, reservation r WHERE f.id_reserv=r.id_reserv AND r.id_reserv='".$_GET['id']."' AND f.s ='1' AND f.rest_a_pay <'".$arg."' ORDER BY f.hr_emi DESC, f.dat_emi DESC LIMIT 1");
                            $f = $ver->fetchAll();
                            $ct = count($f);
                            if($ct == 0)// ca depasse pas
                            {
                              //refaire la requete pour prendre le montant rest a payer de la dernière facture
                              $montr = $bdd->query("SELECT SQL_NO_CACHE f.rest_a_pay FROM facture f, reservation r  WHERE f.id_reserv=r.id_reserv AND r.id_reserv='".$_GET['id']."' AND f.s ='1' ORDER BY f.hr_emi DESC LIMIT 1");
                              $mon = $montr->fetch();
                              $rest = intval($mon[0]) - $arg;//faire la soustraction
                              $_SESSION['rest'] = $rest;

                              //il faut verifier si le reste devient zéro alors on doit solder la réservation
                              if( $_SESSION['rest'] == 0)
                              {
                                $solder = (new reservation())->update_statut($_GET['id']);
                              }
                              //insertion de la facture
                              $insert = (new facture())->insertfact($idfact, $arg, $_GET['id'], $_SESSION['date'], $rest, $hr, $pay_mod);

                              //les elements pour la facture
                              //les tarifs et le nom de l'appart
                              $choisi = $bdd->query("SELECT SQL_NO_CACHE a.tar_jour, a.lib_appart FROM appartement a, reservation r WHERE a.id_appart=r.id_appart AND r.id_reserv='".$_GET['id']."' ");
                              $tarifs = $choisi->fetch();
                              $_SESSION['desig'] = $tarifs[1];
                              $_SESSION['p1'] = $tarifs[0];
                              //nom et prenoms du client
                              $cl = $bdd->query("SELECT SQL_NO_CACHE nom_clt, pnom_clt FROM client WHERE id_clt='".$_GET['clt']."' ");
                              $clt = $cl->fetch();
                              $_SESSION['nom'] = $clt[0];
                              $_SESSION['pnom'] = $clt[1];
                              //nbre de jour et de jours dans reservation
                              $nb = $bdd->query("SELECT SQL_NO_CACHE mont_reserv, nb_jr  FROM reservation WHERE id_reserv='".$_GET['id']."'");
                              $o = $nb->fetch();
                              $_SESSION['montant'] = $o[0];
                              $_SESSION['j'] = $o[1];
                            
                              $_SESSION['reserv'] = $_GET['id'];
                              $_SESSION['fact'] = $idfact;

                             
                              echo'<font color="green">Action effectuée; <a href="../facture/facture.php" >Imprimer facture</a></font>';
                                 
                            }
                            else//ca depasse
                            {
                             echo'<font color="red"> Montant trop élevé! Veuillez entrer un montant plus petit que le précédent</font>';
                            }
                            
                            //mise a jour du statut
                            if($rest = 0)
                            {
                              $maj = (new reservation())->update_statut($_GET['id']);
                            }
                          }
                          else //elle existe
                          {
                             echo'<font color="red">Facture existante!</font>';
                          }
                          
                        }
                       
                      }
                      else
                      {
                        echo'<font color="red">Veuillez saisir le montant svp!</font>';
                      }
                    }
                    else
                    {

                    }
                    echo'</fieldset>';
                    echo'</form>';

                  }

                ?>

                <div class="text-center">
                  <a class="small" href="reservation.php"><font style="font-size: 20px">Retour aux réservations</font></a> OU <a class="small" href="customer.php"><font style="font-size: 20px">Retour a la gestion des clients</font></a>
                </div>
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