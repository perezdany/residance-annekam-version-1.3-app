<?php

	//ici est la classe qui va gérer les réservations
		

	

	class reservation
	{
	
		public function addreserv()
		{
			//traitement pour la reservation
			require 'confige.php';
			if (isset($_POST['submit']))//verifier si notre formulaire a été envoyé
			{

			    $nom =  htmlspecialchars($_POST['nom_client']);//securiser nos variables pour evietr des injection de code
			    $pnom = htmlspecialchars($_POST['prenom_client']);
			    $tel = htmlspecialchars(($_POST['tel']));
			    $mail = htmlspecialchars(($_POST['email']));
			    $title = htmlspecialchars(($_POST['title']));
			    $objet = "Location d'appartement(s) meublé(s)";
			    $appart = intval($_POST['appart']);
			    $adultes = intval($_POST['adlt']);
			    $enfants = intval($_POST['eft']);
			    $jour = intval($_POST['jr']);
			    $add = htmlspecialchars(($_POST['add']));
			    $arrivdate = htmlspecialchars(($_POST['ar']));
			    $timestamp = strtotime($arrivdate); //recupération du timestamp de la date donnée
			    $newdate1 = date("Y-m-d", $timestamp);//conversion2(en anglais)
			    $remise = intval($_POST['remise']);
			    $montant = intval($_POST['montant']);//on ne calcule plus le montant en arriere plan maintenant on entre le montant et la remise
			    //date de la reservation
			    $timestamp1 = strtotime($_POST['dat_reserv']);
			    $dat_reserv = date("Y-m-d", $timestamp1);

			    //calcule de la date de depart
			    $depart = (new calculator())->arrivdate($jour,$newdate1);

			    //verifications
			    if(!empty($_POST['nom_client']) AND !empty($_POST['prenom_client']) AND !empty($_POST['tel']))// verifier si les champs sont remplis
			    {
			      if(strlen($nom) <= 60)
			      {
			        if(strlen($pnom) <= 60)
			        {
			            //verifier si le client est deja dans la base
			            $reqveri = $bdd->prepare("SELECT SQL_NO_CACHE * FROM client WHERE nom_clt=? AND pnom_clt=?");
			            $reqveri->execute(array($nom, $pnom));
			            $l = $reqveri->fetchAll();
			            $n = count($l);
			            if($n == 0)//si il n'est pas dans la base
			            {
			              //mettre le client dans la table
			              
			              $customer = (new Customer())->addcustommer($title, $nom, $pnom, $tel, $mail, $add);
			              
			              //prix unitaire
			              $_SESSION['p1'] = (new calculator())->price($jour, $appart);

			              //recuperer le nom de l'appart
			              $de = (new  appartment())->getnameappart($appart);

			              //requete pour la reservation
			              $id="RESER".date("Ymdhisa");
			              $date=date("Y-m-d");
			              $stat=0;
			              $hr = date("H:i:s");

			               //recuperer le matricule du client
			              $client= (new Customer())->getcustomer($nom, $pnom);

			              $reqverif = $bdd->query("SELECT SQL_NO_CACHE c.id_clt, c.nom_clt FROM client c, reservation r, appartement a WHERE c.id_clt=r.id_clt AND a.id_appart=r.id_appart AND c.nom_clt='".$nom."' AND c.pnom_clt='".$pnom."' AND a.id_appart='".$appart."' AND r.dat_arriv='".$newdate1."' AND r.nb_jr='".$jour."' AND r.nb_adlt='".$adultes."' AND r.nb_enf='".$enfants."' ");//pour eviter que lorsqu'on renvoie le formulaire avec ces meme données la il yait traitement a nouveau
			              $essai = $reqverif->fetchAll();
			              $ok = count($essai);
			              if($ok == 0)
			              {
			                $reserver = $bdd->prepare("INSERT INTO reservation(id_reserv, id_appart, id_clt, dat_reserv, nb_adlt, nb_enf, mont_reserv, dat_arriv, dat_dep, statut, nb_jr, hr_reserv, objet, rem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			                $reserver->execute(array($id, $appart, $client, $dat_reserv, $adultes, $enfants, $montant, $newdate1, $depart, $stat, $jour, $hr, $objet, $remise));

			                //formatage des dates pour les affichages
			                $aftamp1 = strtotime($arrivdate); //recupération du timestamp de la date donnée
			                $afd1 = date("d/m/Y", $aftamp1);
			                $aftamp2 = strtotime($depart); //recupération du timestamp de la date donnée
			                $afd2 = date("d/m/Y", $aftamp2);

			                //inserton de la facture proformat
			                $idfact = "F".date("Ymdhisa");//id de facture
			                $insert = (new facture())->insertfact0($idfact, $montant,  $id, $date, $montant, $hr);
			                
			                //creation des sessions
			                $_SESSION['appart'] = $appart;
			                $_SESSION['nom'] = $nom;
			                $_SESSION['pnom'] = $pnom;
			                $timestampd = strtotime($date);//recuperation du timestanp de la date donnée
			                $_SESSION['date'] = date("d/m/Y", $timestampd);
			                $_SESSION['newdate1'] = $newdate1;
			                $_SESSION['montant'] = $montant;
			                $_SESSION['desig'] = $de;
			                $_SESSION['reserv'] = $id;
			                $_SESSION['j'] = $jour;
			                $_SESSION['fact'] = $idfact;
			                $_SESSION['remise'] = $remise;

			                //MESSAGE DE RESULTAT
			                echo'<font color="green" size="25px">Réservation effectuée<a href="facture/proformat.php">IMPRIMER LA FACTURE</a></font>';

			                //echo"<div style='width:500px'><form id='contact' align='center'><label>".$nom." ".$pnom." a fait une reservation pour <b>&nbsp;&nbsp;".$jour."  jours</b><br>&nbsp;&nbsp;sur appartement reservé: ".$appart."<br> Montant de la réservation:".number_format($montant, 0, ',', ' ')."<br>Début du séjour:<b>".$afd1."</b><br>La réservation prendra fin le <b>".$afd2."</b></label></form>";
			               
			              }
			              else
			              {
			                echo"<h5><font color='red'>impossible de faire cette reservation; elle a déjà étée faite!</font><h5>";
			              }
			            
			              //rediriger sur la facture a meme temps
			            }

			            if($n == 1)//il est dans la base
			            {
			              
			              //prix unitaire
			              $_SESSION['p1'] = (new calculator())->price($jour, $appart);

			              //recuperer le matricule du client
			              $client=(new Customer())->getcustomer($nom, $pnom);

			              //recuperer le nom de l'appart
			              $de = (new  appartment())->getnameappart($appart);

			              $id="RESER".date("Ymdhisa");
			              $text="indefini";
			              $date=date("Y-m-d");
			              $hr = date("H:i:s");
			              $stat=0;
			              //reservation
			              $reqverif = $bdd->query("SELECT SQL_NO_CACHE c.id_clt, c.nom_clt FROM client c, reservation r, appartement a WHERE c.id_clt=r.id_clt AND a.id_appart=r.id_appart AND c.nom_clt='".$nom."' AND c.pnom_clt='".$pnom."' AND a.id_appart='".$appart."' AND r.dat_arriv='".$newdate1."' AND r.nb_jr='".$jour."' AND r.nb_adlt='".$adultes."' AND r.nb_enf='".$enfants."'");//pour eviter que lorsqu'on renvoie le formulaire avec ces meme données la il y ait traitement a nouveau
			              $essai = $reqverif->fetchAll();
			              $ok = count($essai);
			              if($ok == 0)
			              {
			                $reserver = $bdd->prepare("INSERT INTO reservation(id_reserv, id_appart, id_clt, dat_reserv, nb_adlt, nb_enf, mont_reserv, dat_arriv, dat_dep, statut, nb_jr, hr_reserv, objet, rem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			                $reserver->execute(array($id, $appart, $client, $dat_reserv, $adultes, $enfants, $montant, $newdate1, $depart, $stat, $jour, $hr, $objet, $remise));

			                //formatage des dates pour les affichages
			                $aftamp1 = strtotime($arrivdate); //recupération du timestamp de la date donnée
			                $afd1 = date("d/m/Y", $aftamp1);
			                $aftamp2 = strtotime($depart); //recupération du timestamp de la date donnée
			                $afd2 = date("d/m/Y", $aftamp2);

			                //inserton de la facture proformat
			                $idfact = "F".date("Ymdhisa");//id de facture
			                $insert = (new facture())->insertfact0($idfact, $montant,  $id, $date, $montant, $hr);

			                //creation des sessions
			                $_SESSION['appart'] = $appart;
			                $_SESSION['nom'] = $nom;
			                $_SESSION['pnom'] = $pnom;
			                $timestampd = strtotime($date);//recuperation du timestanp de la date donnée
			                $_SESSION['date'] = date("d/m/Y", $timestampd);
			                $_SESSION['newdate1'] = $newdate1;
			                $_SESSION['montant'] = $montant;
			                $_SESSION['desig'] = $de;
			                $_SESSION['reserv'] = $id;
			                $_SESSION['j'] = $jour;
			                $_SESSION['fact'] = $idfact;
			                $_SESSION['remise'] = $remise;

			                //MESSAGE DE RESULTAT
			               echo'<font color="green" size="25px">Réservation effectuée<a href="facture/proformat.php">IMPRIMER LA FACTURE</a></font>';

			               //echo"<div style='width:500px'><form id='contact' align='center'><label>".$nom." ".$pnom." a fait une reservation pour <b>&nbsp;&nbsp;".$jour."  jours</b><br>&nbsp;&nbsp;sur appartement reservé: ".$appart."<br> Montant de la réservation:".number_format($montant, 0, ',', ' ')."<br>Début du séjour:<b>".$afd1."</b><br>La réservation prendra fin le <b>".$afd2."</b></label></form>";
			                
			              }
			              else
			              {
			                echo"<h5><font color='red'>impossible de faire cette reservation; elle a déjà étée faite!</font><h5>";
			              }
			            
			              //rediriger sur la facture a meme temps
			            }
			        }
			        else
			        {
			          $erreur="les prénoms ne doivent pas depasser 60 caractères";
			        }
			      }
			      else
			      {
			        $erreur="votre nom ne doit pas depasser 60 caractères";
			      } 
			    }
			    else
			    {
			      $erreur="veuillez renseigner les champs svp!";
			      if(isset($erreur))
			      {
			        echo '<font color="red"><h5>'.$erreur.'<h5></font>';
			      }
			    }
			}
			else
			{

			}
		}


		public function all_reserv($aujourd)
		{
			require 'confige.php';
		
			//affichage des reservations
			$res = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, r.dat_reserv, r.hr_reserv, r.nb_jr, c.nom_clt, c.pnom_clt, r.statut, a.lib_appart, r.mont_reserv, r.dat_arriv, r.dat_dep, r.objet, c.id_clt, c.title, r.rem FROM reservation r, client c, appartement a WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.statut= 0 AND r.dat_dep > '".$aujourd."'ORDER BY r.dat_reserv DESC, r.hr_reserv DESC");
			return $res;
            
	              
	        
		}

		public function reserv_history()
		{
			require 'confige.php';
			//affichage des reservations
			$res = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, r.dat_reserv, r.hr_reserv, r.nb_jr, c.nom_clt, c.pnom_clt, r.statut, a.lib_appart, r.mont_reserv, r.dat_arriv, r.dat_dep, r.objet, c.id_clt, c.title, r.rem, a.tar_jour, r.dat_arriv, r.rem FROM reservation r, client c, appartement a WHERE r.id_clt=c.id_clt AND r.id_appart=a.id_appart ORDER BY r.dat_reserv DESC, r.hr_reserv DESC");
			return $res;
            
	              
	        
		}

		public function update_statut($id)
		{
			require 'confige.php';

           	$maj = $bdd->query("UPDATE reservation SET statut='1' WHERE id_reserv='".$id."' ");
		}


		public function update_reserv($a, $b, $c, $d, $e, $f, $g, $h, $r)
		{
			require 'confige.php';
			$modifier = $bdd->prepare("UPDATE reservation SET id_appart=?, nb_adlt=?, nb_enf=?, mont_reserv=?, dat_arriv=?, dat_dep=?, nb_jr=?, rem=? WHERE id_reserv=? ");
            $modifier->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $r));
		}

	}
?>