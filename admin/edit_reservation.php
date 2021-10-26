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
  include("../Model/Facture.php");
  include("../Model/Reservation.php");
  include("../Model/Calculator.php");

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

  <title>Edit - reservation</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>


<script language="javascript">

   function numStr(a, b) //se^parateur de millier
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
      resultat = document.createTextNode('Montant après remise: ' + f +' FCFA');
      while (content.firstChild) //pour que si y des noeuds texts precedent on supprime
      {
        content.removeChild(content.firstChild);
      }
      content.appendChild(resultat);
    }

    function recup_index()//code pour recuperer l'index de l'apparttement
    {
      app = document.form.ap.selectedIndex;//recuperer l'element
      i = document.form.ap.options[app].value; //recuperer la valeur
      //avant il faut recupérer les valeur de chaque champ préremplie pour pour pouvoir les réafficher quand on renvoyera l'id
      /*name = document.getElementById("name").value;
      pname = document.getElementById("pname").value;
      adlt = document.getElementById("adlt").value;
      enf = document.getElementById("enf").value;
      date = document.getElementById("date").value;
      days = document.getElementById("j").value;*/
      window.location.href = "mod.php?i="+i//+"&name="+name+"&pname="+pname+"&mail="+adlt+"&enf="+enf+"&date="+date+"&days="+days; //passer en url l'index de l'appart
    }
  </script>

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
                  <h1 class="h4 text-gray-900 mb-4">Modification de réservation</h1>
                </div>
               
                <form class="user" method="post" name="form">

                  <?php
                  //reservations
                  if(isset($_GET['clt']) AND isset($_GET['id']) AND isset($_GET['statut']))
                  {
                    $_SESSION['idc'] = $_GET['clt']; 
                   $_SESSION['idr'] = $_GET['id'];
                    $res =  $bdd->query("SELECT SQL_NO_CACHE r.id_appart, r.nb_adlt, r.nb_enf, r.dat_arriv, r.nb_jr, c.nom_clt, c.pnom_clt, a.lib_appart, r.mont_reserv, r.rem FROM reservation r, appartement a, client c WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.id_clt='".$_GET['clt']."' AND r.id_reserv='".$_GET['id']."'");
                    while($elmt = $res->fetch())
                    {
                      $ancien_mont = intval($elmt[8]);
                      $ancien_appart = intval($elmt[0]);
                      $_SESSION['nom'] = $elmt[5];
                      $_SESSION['pnom'] = $elmt[6];
                      $_SESSION['idap'] = $elmt[0];
                       $_SESSION['adl'] = $elmt[1];
                      $_SESSION['desig'] = $elmt[7];
                      $_SESSION['e'] = $elmt[2];
                       $_SESSION['j'] = $elmt[4];
                      $_SESSION['rem'] = $elmt[9];
                      $_SESSION['date'] = date('Y-m-d');
                      $_SESSION['statut']  = $_GET['statut'];

                    }
                  }

                  if(isset($_SESSION['idc']) AND isset($_SESSION['idr']) AND isset($_GET['statut']))
                  {
                   
                    $res =  $bdd->query("SELECT SQL_NO_CACHE r.id_appart, r.nb_adlt, r.nb_enf, r.dat_arriv, r.nb_jr, c.nom_clt, c.pnom_clt, a.lib_appart, r.mont_reserv, r.rem  FROM reservation r, appartement a, client c WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.id_clt='".$_SESSION['idc']."' AND r.id_reserv='".$_SESSION['idr']."'");
                    while($elmt = $res->fetch())
                    {
                      $ancien_mont = intval($elmt[8]);
                      $ancien_appart = intval($elmt[0]);
                      $_SESSION['nom'] = $elmt[5];
                      $_SESSION['pnom'] = $elmt[6];
                      $_SESSION['idap'] = $elmt[0];
                      $_SESSION['adl'] = $elmt[1];
                      $_SESSION['desig'] = $elmt[7];
                      $_SESSION['e'] = $elmt[2];
                      $_SESSION['j'] = $elmt[4];
                      $_SESSION['rem'] = $elmt[9];
                      $_SESSION['date'] = date('Y-m-d');
                      $_SESSION['statut']  = $_GET['statut'];
                      
                    }
                  }
                  ?>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        Nom:
                        <input type="text" name="nom"  class="form-control form-control-user" id="exampleFirstName" disabled  id="name" value=<?php if(isset($_SESSION['nom'])){echo$_SESSION['nom'];} ?> >
                      </div>
                      <div class="col-sm-6">
                      Prénom(s):
                      <input type="text" name="pnom" class="form-control form-control-user" id="exampleLastName" id="pname" disabled value=<?php if(isset($_SESSION['pnom'])){echo$_SESSION['pnom'];}?> >
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        APPARTEMENT:
                        <select name="ap" class="form-control form-control" id="app">
                          
                        <?php
                          
                          //meme processus que dans la page indexview
                          $aujourd = date('Y-m-d');//prendre la date de today


                          //au cas ou js nous renvoie
                          if(isset($_GET['i']))
                          {
                            $appsel = $bdd->query("SELECT DISTINCT a.id_appart, a.lib_appart FROM appartement a, batiment b WHERE a.id_bat=b.id_bat AND a.id_appart='".$_GET['i']."'");
                            $selct = $appsel->fetch();
                            echo '<option value="'.$selct[0].'">'.$selct[1].'</option>';
                          }
                          elseif(isset($_SESSION['idap']))
                          {
                            echo '<option value="'.$_SESSION['idap'].'">'.$_SESSION['desig'].'</option>';
                          }
                          else
                          {

                          }
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
                            $voirreserv=$bdd->query('SELECT SQL_NO_CACHE r.id_appart FROM reservation r, appartement a WHERE r.id_appart=a.id_appart AND "'.$aujourd.'" < r.dat_dep AND a.id_appart="'.$i[0].'" AND r.statut=1 ');
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
                        <select><br>
                        </div>
                        <div class="col-sm-6">
                        Nombre d'adultes:
                          <select name="adlt" style="width:200px; height: 70px>" class="form-control" id="adlt">';
                            <option value=<?php if(isset($_SESSION['adl'])){echo$_SESSION['adl'];}?> ><?php if(isset($_SESSION['adl'])){echo$_SESSION['adl'];}?></option>';
                            <?php
                              
                              for($a=0; $a<=10; $a++)
                              {
                                echo'<option value="'.$a.'" >'.$a.'</option>';
                              }
                            ?>
                           
                          </select>
                        </div>
                      </div>
                         
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        Nombre d'enfants ex:0,1,2...
                        <select name="enf" style="width:250px; height: 70px>" class="form-control" id="enf">';
                          <option value=<?php if(isset($_SESSION['e'])){echo$_SESSION['e'];}?> ><?php if(isset($_SESSION['e'])){echo$_SESSION['e'];}?></option>
                          <?php
                            for($b=0; $b<=10; $b++)
                            {
                              echo'<option value="'.$b.'" >'.$b.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-sm-6">
                       Date d'arrivée:<input type="date"/ name="ar" class="form-control form-control-user" id="date"  value=<?php if(isset($_SESSION['date'])){echo$_SESSION['date'];}?> >
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        Nombre de jours ex:0,1,2...
                        <select name="jr" style="width:250px" height: 70px class="form-control" id="j">
                        <option value=<?php if(isset($_SESSION['j'])){echo$_SESSION['j'];} ?> ><?php if(isset($_SESSION['j'])){echo$_SESSION['j'];}?></option>
                          <?php
                            for($c=0; $c<=30; $c++)
                            {
                              echo'<option value="'.$c.'" >'.$c.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-sm-6">
                       
                      </div>
                    </div>
                    <?php

                       if(isset($_SESSION['statut']))
                       {
                          if(intval($_SESSION['statut']) == 0)
                          {
                            echo'<div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                              Remise(<b>%</b>):
                              <input type="text" name="remise" style="width:100px" height: 50px class="form-control" id="rem" value=';  if(isset($_SESSION['rem'])){echo $_SESSION['rem'];}else{echo "0";}echo'>
                            </div>
                            <div class="col-sm-6">
                              Nouveau montant (défintif de la réservation):
                              <input type="text" name="montant" style="width:310px" height: 50px class="form-control" id="rem" >
                            </div>
                          </div>';
                          }
                          else
                          {

                          }
                          
                       }
                        
                       
                    ?>
                    

                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                      <button type="submit" name="mod" class="btn btn-primary">MODIFIER</button></div>
                      <div class="col-sm-6"><button type="reset" name="reset" class="btn btn-danger">ANNULER</button>
                    </div>
              <?php


              //traitement pour la modification
              if(isset($_POST['mod']))
              {

                //reservations
                  if(isset($_GET['clt']) AND isset($_GET['id']))
                  {
                    $_SESSION['idc'] = $_GET['clt']; 
                    $_SESSION['idr'] = $_GET['id'];
                    //selectionner la réservation en question en vue de récupérer certaies données pour la facture
                    $res =  $bdd->query("SELECT SQL_NO_CACHE r.id_appart, r.nb_adlt, r.nb_enf, r.dat_arriv, r.nb_jr, c.nom_clt, c.pnom_clt, a.lib_appart, r.mont_reserv, r.rem FROM reservation r, appartement a, client c WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.id_clt='".$_GET['clt']."' AND r.id_reserv='".$_GET['id']."'");
                    while($elmt = $res->fetch())
                    {
                      $ancien_mont = intval($elmt[8]);
                      $ancien_appart = intval($elmt[0]);
                      $_SESSION['nom'] = $elmt[5];
                      $_SESSION['pnom'] = $elmt[6];
                      $_SESSION['idap'] = $elmt[0];
                       $_SESSION['adl'] = $elmt[1];
                      $_SESSION['desig'] = $elmt[7];
                      $_SESSION['e'] = $elmt[2];
                      $_SESSION['j'] = $elmt[4];
                      $_SESSION['rem'] = $elmt[9];
                      $_SESSION['date'] = date('Y-m-d');
                      $_SESSION['idr'] = $_GET['id'];
                    }
                  }

                  if(isset($_SESSION['idc']) AND isset($_SESSION['idr']))
                  {

                   $res =  $bdd->query("SELECT SQL_NO_CACHE r.id_appart, r.nb_adlt, r.nb_enf, r.dat_arriv, r.nb_jr, c.nom_clt, c.pnom_clt, a.lib_appart, r.mont_reserv, r.rem FROM reservation r, appartement a, client c WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.id_clt='".$_SESSION['idc']."' AND r.id_reserv='".$_SESSION['idr']."'");
                    while($elmt = $res->fetch())
                    {
                      $ancien_mont = intval($elmt[8]);
                      $ancien_appart = intval($elmt[0]);
                      $_SESSION['nom'] = $elmt[5];
                      $_SESSION['pnom'] = $elmt[6];
                      $_SESSION['idap'] = $elmt[0];
                       $_SESSION['adl'] = $elmt[1];
                      $_SESSION['desig'] = $elmt[7];
                      $_SESSION['e'] = $elmt[2];
                      $_SESSION['j'] = $elmt[4];
                       $_SESSION['rem'] = $elmt[9];
                      $_SESSION['date'] = date('Y-m-d');
                      
                    }
                  }

                  //requete pour la modification
                  $appart = intval($_POST['ap']);
                  $adultes = intval($_POST['adlt']);
                  $enf = intval($_POST['enf']);
                  $jr = intval($_POST['jr']);
                  $montant = intval($_POST['montant']);
                  $arrivdate = htmlspecialchars($_POST['ar']);
                  $timestamp = strtotime($arrivdate); //recupération du timestamp de la date donnée
                  $newdate1 = date("Y-m-d", $timestamp);
                  $remise = intval($_POST['remise']);
                  //creation des sessions
                  $_SESSION['appart'] = $appart;
                  $_SESSION['newdate1'] = $newdate1;
                  $_SESSION['j'] = $jr;
                  $_SESSION['remise'] = $remise;
                  $hr = date("H:i:s");

                  //changer le montant de la reservation aux cas ou ya changment

                  //extraire les tarifs de l'appart choisi
                  $choisi = $bdd->query("SELECT SQL_NO_CACHE tar_jour, tar_mois FROM appartement WHERE id_appart='".$appart."'");
                  $tarifs = $choisi->fetch();

                  //l'utilisateur entre lui meme le montant donc les calculs se font par lui-meme
                 
                  //session pour le  montant
                  $_SESSION['montant'] = $montant;

                  //calcul des nouvelles dates de depart en ajoutant juste les valeur des jour
                  $depart = (new Calculator())->leaving_date($jr, $newdate1);
                  
                  //generer le nouveau montant : faire une nouvelle facture avec le nouveau reste a payer
                  if($montant != $ancien_mont)
                  {
                    //Selctionner le montant qui reste a payer de la derniere facture payée
                    $montr = $bdd->query("SELECT SQL_NO_CACHE f.rest_a_pay FROM facture f, reservation r  WHERE f.id_reserv=r.id_reserv AND f.s = 1  AND r.id_reserv='".$_SESSION['idr']."' ORDER BY f.rest_a_pay ASC LIMIT 1");
                    $observ = $montr->fetchAll();
                    $compte = count($observ);
                    if($compte == 0)//y a pas de facture payée
                    {
                      //faire une facture (proformat)
                      
                        //supprimer les anciennes facture qui pourraient nous tromper...
                        $fa = $bdd->query('SELECT f.id_fact FROM facture f , reservation r WHERE f.id_reserv=r.id_reserv AND f.s=0  AND r.id_reserv="'.$_SESSION['idr'].'" ');

                        while($idf = $fa->fetch())
                        {
                          $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$idf[0]."'");
                          
                        }      

                         //Identifiant de la facture
                        $hr = date("H:i:s");
                        $idfact = "F".date("Ymdhisa");//id de facture
                        $_SESSION['fact'] = $idfact;//recuperer pour envoyer ca dans la facture

                        //insertion de la facture; on considère qu'elle est proformat
                        $insert = (new facture())->insertfact0($idfact, $montant, $_SESSION['idr'], $_SESSION['date'], $montant, $hr);

                        //modifier la réservation
                        $update = (new Reservation())->update_reserv($appart, $adultes, $enf, $montant, $newdate1, $depart, $jr, $remise, $_SESSION['idr']);
                          
                        //redirection vers la facture
                         echo'<font color="green" size="25px">Modification effectuée<font/><br><a href="../facture/factmod.php">Imprimer la facture<a/>';
                         $_SESSION['rest']= $montant;//puisqu'il n'a pas encore payé le montant restant est identique au montant de la réservation
                     
                    }
                    else //y a facture payée
                    {
                      //recuper le montant de toutes les anciennes factures reglée de la reservation
                      $anfact = $bdd->query("SELECT SQL_NO_CACHE f.mont_sur_fact FROM facture f, reservation r WHERE f.id_reserv=r.id_reserv and r.id_reserv='".$_SESSION['idr']."' AND f.s ='1' ");
                      $som = 0;
                      while($p = $anfact->fetch())
                      {
                        $som += $p[0];
                      }
                      //faire la soustraction du nouveau montant et de $som
                      $rest = $montant - $som;
                      $_SESSION['rest'] = $rest;
                     
                      //modifier la réservation si après la modification la réservation est soldée ($rest == 0)
                      if ($rest == 0)
                      {

                         //suppression de la facture proformat ancienne Supprimer maintenant la facture dont on a plus besoin
                      
                          $fa = $bdd->query('SELECT f.id_fact FROM facture f , reservation r WHERE f.id_reserv=r.id_reserv AND f.s=0  AND r.id_reserv ="'.$_SESSION['idr'].'"');
                          while($idf = $fa->fetch())
                          {
                         
                            $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$idf[0]."'");
                            
                          }

                        //Identifiant de la facture
                        $hr = date("H:i:s");
                        $idfact = "F".date("Ymdhisa");//id de facture
                        $_SESSION['fact'] = $idfact;//recuperer pour envoyer ca dans la facture
                        //nouvelle facture (proformat)
                        $insert = (new facture())->insertfact0($idfact, $montant, $_SESSION['idr'], $_SESSION['date'], $montant, $hr);

                       
                        //modifier le statut de la réservation
                        $update_statut = (new Reservation())->update_statut($_SESSION['idr']);

                         //modifier la réservation
                        $update = (new Reservation())->update_reserv($appart, $adultes, $enf, $montant, $newdate1, $depart, $jr, $remise, $_SESSION['idr']);

                         //suppression ds anciennes factures de règlementet faire une facture de règlement qui regroupe tous les payements
                      
                          $fa = $bdd->query('SELECT f.id_fact FROM facture f , reservation r WHERE f.id_reserv=r.id_reserv AND f.s=1  AND r.id_reserv ="'.$_SESSION['idr'].'"');
                          while($idf = $fa->fetch())
                          {
                         
                            $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$idf[0]."'");
                            
                          }
                            //Identifiant de la facture
                        $hr = date("H:i:s");
                        $idfact = "F".date("Ymdhisa");//id de facture
                        $_SESSION['fact'] = $idfact;//recuperer pour envoyer ca dans la facture

                        //insertion de la facture; on considère qu'elle est payée cette fois avec le rest 0
                        $insert = (new facture())->insertfact($idfact, $montant, $_SESSION['idr'], $_SESSION['date'], $rest, $hr, 4);


                      }
                      else//la réservation n'est pas soldée
                      {
                        //Identifiant de la facture
                        $hr = date("H:i:s");
                        $idfact = "F".date("Ymdhisa");//id de facture
                        $_SESSION['fact'] = $idfact;//recuperer pour envoyer ca dans la facture
                        
                        //modifier la réservation
                        $update = (new Reservation())->update_reserv($appart, $adultes, $enf, $montant, $newdate1, $depart, $jr, $remise, $_SESSION['idr']);

                        //suppression de la facture proformat ancienne Supprimer maintenant la facture dont on a plus besoin
                      
                          $fa = $bdd->query('SELECT f.id_fact FROM facture f , reservation r WHERE f.id_reserv=r.id_reserv AND f.s=0  AND r.id_reserv ="'.$_SESSION['idr'].'"');
                          while($idf = $fa->fetch())
                          {
                         
                            $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$idf[0]."'");
                            
                          }
                        
                        //insertion de la facture (une facture proformat) d'abord
                        $insert = (new facture())->insertfact0($idfact, $montant, $_SESSION['idr'], $_SESSION['date'], $montant, $hr);

                        //supprimer les ancienes facture de règlement et mettre une nouvelle qui resume tout
                        
                        $fa = $bdd->query('SELECT f.mont_sur_fact, f.id_fact FROM facture f , reservation r WHERE f.id_reserv=r.id_reserv AND f.s=1  AND r.id_reserv="'.$_SESSION['idr'].'" ');
                        //on va recuperer le montant qu'il a payé
                        $p = 0;
                        while($idf = $fa->fetch())
                        {
                          $p += intval($idf[0]);
                          $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$idf[1]."'");
                        }
                        $idfact = "F".date("Ymdhisa");//id de facture
                        $newf  = (new facture())->insertfact($idfact, $p, $_SESSION['idr'], $_SESSION['date'], $rest, $hr, 4);

    
 
                      }

                    //redirection vers la facture
                    echo'<font color="green" size="25px">Modification effectuée<font/><br><a href="../facture/factmod.php">Imprimer la facture<a/>';

                    }

                  }
                  else
                  {
                    echo"Aucune modification particulière n'a été faite sur cette réservation";
                  }
                
              }    
              else
              {

              }
              ?>
                <hr>
                  <div class="text-center">
                    <a class="small" href="reservation.php"><font style="font-size: 20px">Retour aux réservations</font></a> OU <a class="small" href="customer.php"><font style="font-size: 20px">Retour a la gestion des clients</font></a>
                  </div>
                </form>
                <hr>
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