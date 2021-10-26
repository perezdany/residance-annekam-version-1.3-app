<?php
	//ici c'est la classe qui gère les appartment

	class appartment
	{
		public function appdispo()//appart dispo
		{
			require 'confige.php';
			$aujourd = date('Y-m-d');//prendre la date de today

			//prendre le nombre d'appart dans la base
            $q = $bdd->query('SELECT * FROM appartement');
            $all = $q->fetchAll();
            $napp = count($all);
           
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
	            //selectionion de l'appart en question
	            $app = $bdd->query("SELECT SQL_NO_CACHE DISTINCT a.id_appart, b.lib_bat,  a.lib_appart, a.tar_jour, a.tar_mois FROM appartement a, batiment b WHERE a.id_bat=b.id_bat AND a.id_appart='".$i[0]."'");
	            while($aff = $app->fetch())
	            {
	              //voir combien de lit tel appartement a
	              $requete2 = $bdd->query("SELECT SQL_NO_CACHE * FROM lit l, appartement a WHERE l.id_appart=a.id_appart AND a.id_appart='".$i[0]."'");
	              //compter le nombre de lits
	              $nbf = $requete2->fetchAll();
	              $nblits = count($nbf);
	              //requete3 pour compter le nombre de place
	              $requete3 = $bdd->query("SELECT SQL_NO_CACHE l.nb_place FROM lit l, appartement a WHERE l.id_appart=a.id_appart AND a.id_appart='".$i[0]."'");
	              $places = 0;
	              while($cpt = $requete3->fetch())
	              {
	                $places = $places + $cpt[0];
	              } 
	              echo "<tr>
	              	<td><button type='button' class='collapsible btn btn-circle bg-gradient-success'><font color='white'><i class='fa fa-angle-down'></i></font></button>
	              	<div class='content' style='display:none;'>
	              		<p>Numéro de l'apartement:  ".$aff[0]."<br>Batiment:  ".$aff[1]."<br>Tarif journalier(FCFA):  ".number_format($aff[3], 0, ',', ' ')."<br>Tarif mensuel(FCFA):  ".number_format($aff[4], 0, ',', ' ')."<br>Nombre de lits:  ".$nblits."<br>Nombre de places:  ". $places."</p>
	              	</div></td><td>".$aff[2]."</td></tr>"; 
	                  
	            }

	          }
	          else//la a meme temps on conclu que l'appart n'est pas libre
	          {

	          } 
	        
			}
		}

		public function appdispo1()
		{
			require 'confige.php';
			$aujourd = date('Y-m-d');//prendre la date de today
            //affichage des apparts dispos en fonction des durées d'occupation des chambres
            for($cpte=1; $cpte<=11; $cpte++)
            {
              //SELECT SQL_NO_CACHEionner les id des appartement qui sont oqp dans la table reservation
              $voirreserv=$bdd->query('SELECT SQL_NO_CACHE r.id_appart FROM reservation r, appartement a WHERE r.id_appart=a.id_appart AND "'.$aujourd.'" < r.dat_dep AND a.id_appart="'.$cpte.'" ');
              $ver=$voirreserv->fetchAll();
              $nb1 =  count($ver);
              if($nb1 == 0)// cad si ce appartement la est libre
              {
                //SELECT SQL_NO_CACHEion de l'appart en question
                $app = $bdd->query("SELECT SQL_NO_CACHE DISTINCT a.id_appart, a.lib_appart FROM appartement a, batiment b WHERE a.id_bat=b.id_bat AND a.id_appart='".$cpte."'");
                while($aff = $app->fetch())
                {
                  echo '<option value="'.$aff[0].'">'.$aff[1].'</option>';       
                }

              }
              else//la a meme temps on conclu que l'appart n'est pas libre
              {

              } 
            }

		}

	
		public function table()
		{
			require 'confige.php';
			//tabelau de bord
			$num_mois = date('n'); // numero du mois
			$num_an = date('Y'); //l'an
			$number = cal_days_in_month(CAL_GREGORIAN, $num_mois, $num_an);// nombre de jour du mois

			//on va recuperer ses variables dans des sessions pour l'impression
			$_SESSION['num_mois'] = $num_mois;
			$_SESSION['num_an'] = $num_an;
			$_SESSION['number'] = $number;
			
			//faire des boucles ecrires les cellules de l'entete
			echo'<thead><tr class="row100 head"><th class="column100 column1">DESIGNATIONS/JOURS</th>';
			for($a=1; $a<=$number; $a++)
			{
				echo'<th class="column100 column'.($a+1).'" align="center">'.$a.'</th>';
			}
			echo'<th class="column100 column'.($a+1).'" align="center">Nombre total de jours d\'occupation</th>';
			echo'<th class="column100 column'.($a+2).'" align="center">tarifs total mensuel</th>';
			echo'</tr></thead>';//fin en tete
			echo'<tbody>';
			$c = 1;
			//boucle pour les cellules du corps
			$ap = $bdd->query("SELECT SQL_NO_CACHE a.lib_appart, a.id_appart FROM appartement a");
			while($n = $ap->fetch())
			{
				echo'<tr class="row100">';
				echo'<td class="column100 column'.$c.'">'.$n[0].'</td>';
				$tot = 0;
				$j = 0;
				for($a=1; $a<=($number); $a++)
				{
					$d = $num_an."-".$num_mois."-".$a;
					//requete pour voir si l'appart est ocupé ce jour la
					$req = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.mont_reserv FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND a.id_appart='".$n[1]."' AND '".$d."'  BETWEEN r.dat_arriv AND r.dat_dep ");
					
					$fall = $req->fetchAll();
					$co = count($fall);
					if($co == 0)//pas occupé
					{
						echo'<td class="column100 column'.($a+1).'"></td>';
					}
					else
					{

						echo'<td class="column100 column'.($a+1).'" style="background-color:#ee7a7a;"></td>';
						
					}
					
				}
				
				//pour afficher les prix des apparts qui ont été soldés
				$dd = $num_an.'-'.$num_mois.'-01';
				$df = $num_an."-".$num_mois.'-'.$number;
				
				$quer = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.nb_jr, r.mont_reserv  FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND r.statut=1 AND a.id_appart='".$n[1]."' AND dat_dep >= '".$dd."' AND dat_dep <= '".$df."'");
				$all = $quer->fetchAll();
				$nb = count($all);
				if($nb == 0)
				{
					echo'<td class="column100 column'.($a+1).'" align="center">0</td>';
					echo'<td class="column100 column'.($a+2).'" align="center">0</td>';
					echo'</tr>';
				}
				else
				{
					$quer = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.nb_jr, r.mont_reserv  FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND r.statut=1 AND a.id_appart='".$n[1]."' AND dat_dep >= '".$dd."' AND dat_dep <= '".$df."'");
					while($af = $quer->fetch())
					{
						$tot = $tot + $af[3];
						$j = $j + $af[2];
						
						
					}
					echo'<td class="column100 column'.($a+1).'" align="center">'.$j.'</td>';
					echo'<td class="column100 column'.($a+2).'" align="center">'.$tot.'</td>';
					echo'</tr>';
				}
				
			}
				
			echo'</tbody>';
		}
			
		public function old_table($month, $year)
		{
			require 'confige.php';
			//tabelau de bord
			
			$number = cal_days_in_month(CAL_GREGORIAN, ($month+1), $year);// nombre de jour du mois
			/*$_SESSION['num_mois'] = $month;
			$_SESSION['num_an'] = $year;
			$_SESSION['number'] = $number;*/
			
			//faire des boucles ecrires les cellules de l'entete
			echo'<thead><tr class="row100 head"><th class="column100 column1">DESIGNATIONS/JOURS</th>';
			for($a=1; $a<=$number; $a++)
			{
				echo'<th class="column100 column'.($a+1).'" align="center">'.$a.'</th>';
			}
			echo'<th class="column100 column'.($a+1).'" align="center">Nombre total de jours d\'occupation</th>';
			echo'<th class="column100 column'.($a+2).'" align="center">tarifs total mensuel</th>';
			echo'</tr></thead>';//fin en tete
			echo'<tbody>';
			$c = 1;
			//boucle pour les cellules du corps
			$ap = $bdd->query("SELECT SQL_NO_CACHE a.lib_appart, a.id_appart FROM appartement a");
			while($n = $ap->fetch())
			{
				echo'<tr class="row100">';
				echo'<td class="column100 column'.$c.'">'.$n[0].'</td>';
				$tot = 0;
				$j = 0;
				for($a=1; $a<=($number); $a++)
				{
					$d = $year."-".($month+1)."-".$a;
					//requete pour voir si l'appart est ocupé ce jour la
					$req = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.mont_reserv FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND a.id_appart='".$n[1]."' AND '".$d."' >= r.dat_arriv AND '".$d."' <= r.dat_dep ");
					
					$fall = $req->fetchAll();
					$co = count($fall);
					if($co == 0)//pas occupé
					{
						echo'<td class="column100 column'.($a+1).'"></td>';
					}
					else
					{

						echo'<td class="column100 column'.($a+1).'" style="background-color:#ee7a7a;"></td>';
						
					}
					
				}
				$dd = $year."-".($month+1).'-01';
				$df = $year."-".($month+1).'-'.$number;
				
				//pour afficher les prix des apparts qui ont été soldés
				//AND '".$d."' >= '".$dd."' AND '".$d."' <= '".$df."'
				$quer = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.nb_jr, r.mont_reserv  FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND r.statut=1 AND a.id_appart='".$n[1]."' AND dat_dep >= '".$dd."' AND dat_dep <= '".$df."' ");
				$all = $quer->fetchAll();
				$nb = count($all);
				if($nb == 0)
				{
					echo'<td class="column100 column'.($a+1).'" align="center">0</td>';
					echo'<td class="column100 column'.($a+2).'" align="center">0</td>';
					echo'</tr>';
				}
				else
				{
					$quer = $bdd->query("SELECT SQL_NO_CACHE r.id_reserv, a.id_appart, r.nb_jr, r.mont_reserv  FROM reservation r, appartement a WHERE a.id_appart=r.id_appart AND r.statut=1 AND a.id_appart='".$n[1]."' AND dat_dep >= '".$dd."' AND dat_dep <= '".$df."'");
					while($af = $quer->fetch())
					{
						$tot = $tot + $af[3];
						$j = $j + $af[2];
						
						
					}
					echo'<td class="column100 column'.($a+1).'" align="center">'.$j.'</td>';
					echo'<td class="column100 column'.($a+2).'" align="center">'.$tot.'</td>';
					echo'</tr>';
				}
			}
				
			echo'</tbody>';

		}
			

		public function ca()
		{
			require 'confige.php';
			echo'<thead><tr class="row100 head"><th class="column100 column1">DESIGNATIONS</th><th class="column100 column5">Chiffre D\'affaires du mois</th>';
			echo'<tbody>';
			//SELECT SQL_NO_CACHEion de l'appart
			$selappart = $bdd->query("SELECT SQL_NO_CACHE id_appart, lib_appart FROM appartement");
			$ca = 0;
			while($aff = $selappart->fetch())
			{
				//recherche d'une reservation sur cet appart
				$res = $bdd->query("SELECT SQL_NO_CACHE r.mont_reserv from appartement a, reservation r WHERE a.id_appart=r.id_appart AND a.id_appart='".$aff[0]."' AND r.statut='1' ");
				while($recup = $res->fetch())
				{
					$ca+=intval($recup[0]);
				}
				echo"<tr class='row100'><td class='column100 column2' data-column='column2' style='width:100px'>".$aff[1]."</td><td class='column100 column5' data-column='column5' style='width:100px'>".number_format($ca, 0, ',', ' ')."</td></tr>";
				$ca = 0;
			}
			echo'</tbody>';
		}

		public function getnameappart($id)
		{
			require ('confige.php');
			$ap=$bdd->query("SELECT SQL_NO_CACHE lib_appart from appartement WHERE id_appart='".$id."'");
            $desig = $ap->fetch();
            return $desig[0];
		}

		public function all_appart()
		{
			require ('confige.php');
			$see = $bdd->query('SELECT SQL_NO_CACHE a.id_appart, a.lib_appart, a.tar_jour, a.tar_mois, b.lib_bat FROM appartement a, batiment b WHERE a.id_bat=b.id_bat');
			return $see;
			
		}

		public function add_appart($name, $tj, $tm, $bat)
		{
			require ('confige.php');

			$add = $bdd->prepare('INSERT INTO appartement(id_appart, lib_appart, tar_jour, tar_mois, id_bat) VALUES (?, ?, ?, ?, ?)');
			$add->execute(array(NULL, $name, $tj, $tm, $bat));
		}

		public function edit_appart($name, $tj, $tm, $bat, $id)
		{
			require ('confige.php');
			$edit = $bdd->prepare('UPDATE appartement SET  lib_appart=?, tar_jour =?, tar_mois=?, id_bat =? WHERE id_appart=?');
			$edit->execute(array($name, $tj, $tm, $bat, $id));
		}
	}
?>