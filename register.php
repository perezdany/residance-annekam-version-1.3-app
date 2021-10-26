<?php
  session_start();

  //chargement des modules
  include("Model/confige.php");

  require "Model/Reservation.php";
  //charger les classes dont on a besoin
  require'Model/Customer.php';
  require'Model/Facture.php';
  require'Model/Calculator.php';
  require'Model/Appartment.php';

  //echo "Il est " . date("H:i:s") ; // Affiche l'heure
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
  <title>Admin | Add reservation</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>



<script language="javascript">

 
    function numStr(a, b) 
    {
        a = '' + a;
        b = b || ' ';
        var c = '',
            d = 0;
        while (a.match(/^0[0-9]/)) {
          a = a.substr(1);
        }
        for (var i = a.length-1; i >= 0; i--) {
          c = (d != 0 && d % 3 == 0) ? a[i] + b + c : a[i] + c;
          d++;
        }
        return c;
    }


    function make_rem()//code pour faire le calcule de la remise et afficher
    {
     
      //recuperation des valeurs
      var jr = document.getElementById('j').value;
      var rr = document.getElementById('rem').value;
      var ta = document.getElementById('t').value;
      var taa = document.getElementById('tt').value;
      var content = document.getElementById('resultat')
      //conversion en entier
      r = Number(rr);
      j = Number(jr);
      //calcul du montant
      var mont = 0;
      if(j==28 || j==29)
      {
        mont =  Number(taa);
      }

      if(j==30)
      {
          mont =  Number(taa);
      }
      else
      {
        mont =  Number(ta)*j;
      }
      var mr = Math.round(mont - ((mont*(r/100))/1.18));
      var f = numStr(mr, ' ');
      //afficher le resultat dans notre balise div qui a l'id content
      var resultat = document.createTextNode('Montant après remise: ' + f +' FCFA');
      while (content.firstChild) //pour quensi y des noeuds texts precedent on supprime
      {
        content.removeChild(content.firstChild);
      }
      content.appendChild(resultat);
    }

    function recup_index()//code pour recuperer l'index de l'apparttement
    {
      app = document.form.appart.selectedIndex;//recuperer l'element
      i = document.form.appart.options[app].value; //recuperer la valeur
      //avant il faut recupérer les valeur de chaque champ préremplie pour pour pouvoir les réafficher quand on renvoyera l'id
      name = document.getElementById("exampleFirstName").value;;
      pname = document.getElementById("exampleLastName").value;;
      mail = document.getElementById("exampleInputEmail").value;
      tel = document.getElementById("exampleTel").value;
      add = document.getElementById("exampleAdd").value;
      dat_reserv = document.getElementById("dtr").value;
      window.location.href = "register.php?i="+i+"&name="+name+"&pname="+pname+"&mail="+mail+"&tel="+tel+"&add="+add+"&dat_reserv="+dat_reserv; //passer en url l'index de l'appart
    }
  </script>

<body class="bg-gradient-danger">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
   
       <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-12">
            <div class="p-5">
              <hr/>
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Ajout de réservation</h1>
              </div>
              <div class="text-center text-gray-900 mb-4">
                     Note:(*) Obligatoire<br>
              </div>
              <form class="user" method="post" name="form">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Titre:</label>
                    <select name="title" class="form-control" style="width: 100px">
                      <option>M</option>
                      <option>Mme</option>
                      <option>Mlle</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                   <label>Date de la réservation (*)</label>
                   <input  type="date" name="dat_reserv" class='form-control form-control-user' style="width: 400px" <?php if(isset($_GET['dat_reserv'])) { echo 'value="'.$_GET['dat_reserv'].'"';}?> required id="dtr"> 
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Nom (*)" required name="nom_client" onkeyup="this.value=this.value.toUpperCase()" <?php if(isset($_GET['name'])) { echo 'value="'.$_GET['name'].'"';}?> >
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Prénom(s) (*)" required name="prenom_client" onkeyup="this.value=this.value.toUpperCase()" <?php if(isset($_GET['pname'])) { echo 'value="'.$_GET['pname'].'"';}?>>
                  </div>
                </div>
                <div class="form-group">
                  <input type="" class="form-control form-control-user" id="exampleInputEmail" placeholder="Addresse Email" name="email" style="width: 490px;" <?php if(isset($_GET['mail'])) { echo 'value="'.$_GET['mail'].'"';}?>>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleTel" placeholder="Téléphone  (*)" required name="tel" placeholder="ex:0768756432"> <?php if(isset($_GET['tel'])) { echo 'value="'.$_GET['tel'].'"';}?> 
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleAdd" placeholder="Code Postal" name="add" <?php if(isset($_GET['add'])) { echo 'value="'.$_GET['add'].'"';}?>>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">APPARTEMENTS DISPONIBLES (*)
                    <select type="select" name="appart" required class="form-control" style=" height: 50px" id="a" >
                      <?php
                        //meme processus que dans la page d'accueil
                        $aujourd = date('Y-m-d');//prendre la date de today

                        //au cas ou js nous renvoie
                        if(isset($_GET['i']))
                        {
                          $appsel = $bdd->query("SELECT DISTINCT a.id_appart, a.lib_appart FROM appartement a, batiment b WHERE a.id_bat=b.id_bat AND a.id_appart='".$_GET['i']."'");
                          $selct = $appsel->fetch();
                          echo '<option value="'.$selct[0].'">'.$selct[1].'</option>';
                        }

                        //prendre a chaque fois les ids des apparts
                        $qu = $bdd->query('SELECT id_appart FROM appartement');
                        while($i = $qu->fetch())
                        {
                          //Selectionner les id des appartement qui sont oqp dans la table reservation
                          $voirreserv=$bdd->query('SELECT SQL_NO_CACHE r.id_appart FROM reservation r, appartement a WHERE r.id_appart=a.id_appart AND "'.$aujourd.'" < r.dat_dep AND a.id_appart="'.$i[0].'" ');
                          $ver=$voirreserv->fetchAll();
                          $nb1 =  count($ver);
                          if($nb1 == 0)// cad si ce appartement la est libre
                          {
                            //selection de l'appart en question
                            $app = $bdd->query("SELECT DISTINCT a.id_appart, a.lib_appart, a.tar_jour, a.tar_mois FROM appartement a, batiment b WHERE a.id_bat=b.id_bat AND a.id_appart='".$i[0]."'");
                            while($aff = $app->fetch())
                            {
                              echo '<option value="'.$aff[0].'">'.$aff[1].' <font size="12px">('.$aff[2].'/jours; '.$aff[3].'/Mois)</font></option>';       
                            }

                          }
                          else//la a meme temps on conclu que l'appart n'est pas libre
                          {

                          } 
                        
                        }
                        
                      ?>
                    </select>
                  </div>

                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nombre de jours (*)</label>
                    <select name="jr" class="form-control" style="width: 100px; height: 50px" id="j" required>
                      <?php
                        for($c=0; $c<=30; $c++)
                        {
                          echo'<option value="'.$c.'" >'.$c.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <textarea  name="objet" class="form-control form-control-user" id="" placeholder="" value="Location d'appartement(s) meublé(s)"  style="display: none;"></textarea> 
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    Remise(<b>%</b>):
                    <input type="text" name="remise" class="form-control" style="width:100px" value="0"  id="rem">
                  </div>
                  <div class="col-sm-6">
                    Montant définitif de la réservation(*):
                    <input type="text" name="montant" class="form-control" style="width:260px">
                  </div>
                
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Date d'arrivée (*)</label>
                    <input placeholder="Date d'arrivée" type="date" name="ar" class="form-control form-control-user">
                  </div>
                  <div class="col-sm-6">
                    
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nombre d'adultes</label>
                    <select name="adlt" class="form-control"  style="width: 100px; height: 50px">
                      <?php
                        for($a=0; $a<=10; $a++)
                        {
                          echo'<option value="'.$a.'" >'.$a.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label>Nombre d'enfants ex:0,1,2...</label>
                    <select name="eft" class="form-control"  style="width: 100px; height: 50px">
                      <?php
                        for($b=0; $b<=10; $b++)
                        {
                          echo'<option value="'.$b.'" >'.$b.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div><br><br><br><hr>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <button class="btn btn-primary" type="submit" name="submit">VALIDER</button>
                  </div>
                <div class="col-sm-6 mb-3 mb-sm-0"><button type="reset" name="reset" class="btn btn-danger">ANNULER</button>
                </div>
                <?php
                   //traitement pour la reservation
                  $treat = (new  reservation())->addreserv();
                ?>
              </form><br>
              <hr>
            </div>
            <div class="text-center">
              <a class="small" href="views/indexview.php"><font style="font-size: 20px">Retour</font></a>
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
