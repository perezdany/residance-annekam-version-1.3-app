<?php
	//ici est la classe du calculateur qui fait des calculs dans l'appli

	class calculator
	{
		public function arrivdate($n, $d)
		{
			//calcul des dates depart en ajoutant juste les valeur des jour
		    if($n == 0)
		    {

		    }
		    elseif($n == 30)
		    {
		      $departtime =strtotime($d.'+1 months');
		      $depart = date("Y-m-d", $departtime);
		      return $depart;
		    }
		    else
		    {
		      $departtime = strtotime($d) + ($n * 86400);
		      $depart = date("Y-m-d", $departtime);
		      return $depart;     
		    }
		}

		public function montant($j, $id)
		{
		  require 'confige.php';
		  //extraire les tarifs de l'appart choisi
          $choisi = $bdd->query("SELECT SQL_NO_CACHE tar_jour, tar_mois FROM appartement WHERE id_appart='".$id."'");
          $tarifs = $choisi->fetch();
          $num_mois = date('n');
          if($j==28 OR $j==29 AND $num_mois == 2)
          {
            $montant = intval($tarifs[1]);
            return $montant;
          }
          elseif($j==30)
          {
            $montant = intval($tarifs[1]);
            return $montant;
          }
          else
          {
            $montant = intval($tarifs[0]) * $j;
           	return $montant;
          }
		}

		public function leaving_date($jr, $newdate1)
		{
			if($jr == 0)
        	{

        	}
          	elseif($jr == 30)
          	{
            	$departtime =strtotime($newdate1.'+1 months');
            	$depart = date("Y-m-d", $departtime);
          	}
          	else
          	{
            	$departtime = strtotime($newdate1) + ($jr * 86400);
            	$depart = date("Y-m-d", $departtime);    
          	}

          	return $depart;
		}

		public function price($j, $id)
		{
			require 'confige.php';
		  //extraire les tarifs de l'appart choisi
          $choisi = $bdd->query("SELECT SQL_NO_CACHE tar_jour, tar_mois FROM appartement WHERE id_appart='".$id."'");
          $tarifs = $choisi->fetch();
          //Verifier si le nombre de jours a atteint un mois
          $num_mois = date('n');
          if($j==28 OR $j==29 AND $num_mois == 2)
          {
            return $tarifs[1];
          }
          elseif($j==30)
          {
           	return $tarifs[1];
          }
          else
          {
            return $tarifs[0];
          }
		}

		public function remise($m, $r)
		{
			require 'confige.php';
			$a = $m -(($m * ($r/100))/1.18);
			return $a;
		}

		public function somfacture($id)
		{
			require 'confige.php';
			//recuperer le montant de toutes les anciennes factures reglées de la reservation
            $anfact = $bdd->query("SELECT SQL_NO_CACHE f.mont_pay FROM facture f, reservation r WHERE f.id_reserv=r.id_reserv and r.id_reserv='".$id."' AND f.s ='1' ");
            $som = 0;
            while($p = $anfact->fetch())
            {
                $som += $p[0];
            }
            return $som;
		}

		public function earn_monthly()
		{
			require ('confige.php');
			$cam = 0;
            $n=1;
            $num_mois = date('n');
			$num_an = date('Y');
			$number = cal_days_in_month(CAL_GREGORIAN, $num_mois, $num_an);
			
			//SELECT SQL_NO_CACHEion de l'appart
           $selappart = $bdd->query("SELECT SQL_NO_CACHE id_appart FROM appartement");
            while($aff = $selappart->fetch())
            {
            	for($n=1;$n<=$number;$n++)
	            {
	            	
	            	$date = date(''.$num_an.'-'.$num_mois.'-'.$n.'');
		            //recherche d'une reservation sur cet appart
	                $res = $bdd->query("SELECT SQL_NO_CACHE r.mont_reserv from appartement a, reservation r WHERE a.id_appart=r.id_appart AND a.id_appart='".$aff[0]."' AND r.statut='1' AND r.dat_reserv='".$date."'");
	                while($recup = $res->fetch())
	                {
	                	$cam += intval($recup[0]);
	                }
	                
	            }
	         
            }
            return $cam ;
           
		}


		public function earn_annualy()
		{
			require ('confige.php');
			$an = 0;
			$num_an = date('Y');
			
			//SELECT SQL_NO_CACHEion de l'appart
           $selappart = $bdd->query("SELECT SQL_NO_CACHE id_appart FROM appartement");
            while($aff = $selappart->fetch())
            {
            	for( $num_mois = 1; $num_mois<=12; $num_mois++)
							{
								$number = cal_days_in_month(CAL_GREGORIAN, $num_mois, $num_an);
								for($n=1;$n<=$number;$n++)
		            {
		            	
		            	$date = date(''.$num_an.'-'.$num_mois.'-'.$n.'');
			            //recherche d'une reservation sur cet appart
		                $res = $bdd->query("SELECT SQL_NO_CACHE r.mont_reserv from appartement a, reservation r WHERE a.id_appart=r.id_appart AND a.id_appart='".$aff[0]."' AND r.statut='1' AND r.dat_reserv='".$date."'");
		                while($recup = $res->fetch())
		                {
		                	$an += intval($recup[0]);
		                }
		                
		            }

							}
            	
	         
            }
			return $an;
			
		}

		public function outlay()
		{
			require 'confige.php';
			$tot = 0;
	        $ent = $bdd->query("SELECT SQL_NO_CACHE mont_entretien FROM entretien");
	        while($fen = $ent->fetch())
	        {
	        	$tot += intval($fen[0]);
	        }
	    
	        return $tot;
		}

		public function waiting_reservation()
		{
			require 'confige.php';
			$aujourd = date('Y-m-d');//prendre la date de today
	        $ent = $bdd->prepare("SELECT SQL_NO_CACHE * FROM reservation WHERE statut=? AND dat_dep > ?");
	        $ent->execute(array(0, $aujourd));
	        $f = $ent->fetchAll();
	      	$n = count($f);
	        return $n;
		}

		public function periodly_earn($first_date, $last_date)
		{
			require 'confige.php';
			//il s'agit d'afficher pour chaque client ce qu'il a rapporter sur cette periode
			$search = $bdd->query("SELECT SQL_NO_CACHE c.nom_clt, c.pnom_clt, r.nb_jr, r.mont_reserv, r.dat_reserv, c.title FROM reservation r, client c WHERE r.statut='1' AND c.id_clt=r.id_clt AND r.dat_reserv >= '".$first_date."' AND r.dat_reserv <='".$last_date."' ");
			return $search;
		}
	}
?>