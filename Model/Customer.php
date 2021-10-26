<?php
	//ici est la classe qui va gérer les clients

	class customer
	{
		public function all_customer()
		{
			require 'confige.php';
			$v = $bdd->query("SELECT SQL_NO_CACHE * FROM client ");
	        return $v;
		}

		public function customer_factures($name, $date)
		{
			require 'confige.php';
			//afficher maintenant ces differentes factures 
        	//requete
            $fa =  $bdd->query('SELECT DISTINCT SQL_NO_CACHE f.id_fact, f.mont_sur_fact, f.dat_emi, r.dat_reserv, f.rest_a_pay, r.id_reserv, a.tar_jour, a.lib_appart, r.mont_reserv, r.nb_jr, a.tar_mois, c.pnom_clt , f.s, c.nom_clt, r.statut FROM facture f, reservation r, client c, appartement a WHERE c.id_clt=r.id_clt AND r.id_reserv=f.id_reserv AND r.id_appart=a.id_appart AND f.s=1 AND c.nom_clt="'.$name.'" ORDER BY f.dat_emi DESC, f.hr_emi DESC');
          
            	 echo' <div class="container-fluid">
		            <div class="card shadow mb-4">
		              <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Dernières factures du clients recherché</h6></div>
		              <div class="card-body">
		                <div class="table-responsive">

		                  <table class="table table-bordered" id="" width="100%" cellspacing="0">
		                  <thead><tr><th>Facture N°</th><th><span>Montant payé</span></th><th>Appartement</th><th>Date d\'emission</th><th>Réservation du:</th><th>RESTE A PAYER (FCFA)</th><th>Action</th></tr></thead><tbody>';
					    while($v = $fa->fetch())
			            {
		                   echo'<tr><td>'.$v[0].'</td><td>'.number_format($v[1], 0, ',', ' ').'</td><td>'.$v[7].'</td><td>'.$v[2].'</td><td>'.$v[3].'</td><td>'.number_format($v[4], 0, ',', ' ').'</td><td><button class="btn bg-gradient-success btn-circle"><a href="../facture/facture.php?d='.$v[2].'&amp;i='.$v[0].'&amp;n='. $v[13] .'&amp;p='. $v[11] .'&amp;a='.$v[7].'&amp;j='.$v[9].'&amp;tj='.$v[6].'&amp;pay='.$v[1].'&amp;rest='.$v[4].'&amp;mr='.$v[8].'&amp;tm='.$v[10].'&amp;s='.$v[12].'&amp;rs='.$v[14].'"><font color="white"><i class="fa fa-print"></i></font></a></button</td></tr>';
	    				} 
		                  echo'</tbody></table>
		                </div>
		              </div>

		            </div> 
		          </div>' ;       
           
		}

		public function search_customer($name, $auj)
		{
			//recherche de la reservation en fonction du client
			require 'confige.php';
		
          	//requete de recherche
            $recherche = $bdd->prepare("SELECT SQL_NO_CACHE a.lib_appart, r.dat_arriv, r.dat_dep, r.nb_adlt, r.nb_enf, c.address, c.tel, r.mont_reserv, r.dat_reserv, c.id_clt, r.hr_reserv FROM reservation r, appartement a, client c WHERE c.nom_clt=? AND r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND ".$auj."< r.dat_dep ORDER BY r.dat_reserv");

            $recherche->execute(array($name));
            $ligne = $recherche->fetchAll();
            $n = count($ligne);
            if($n==0)//si la reservation n'existe pas
            {
             	$er="Pas de reservation pour ".$name;
            }
           else//si elle existe
            {
          	    //afficher
              	$recherche = $bdd->prepare("SELECT SQL_NO_CACHE r.id_reserv, a.lib_appart, r.dat_arriv, r.dat_dep, r.nb_adlt, r.nb_enf,  c.mail, r.mont_reserv, r.dat_reserv, c.id_clt,  r.hr_reserv, r.objet, a.id_appart, c.tel, c.nom_clt, c.pnom_clt, r.nb_jr, r.statut FROM reservation r, appartement a, client c WHERE c.nom_clt=? AND  r.id_clt=c.id_clt AND r.id_appart=a.id_appart AND r.statut=0  AND ? < r.dat_dep ORDER BY r.hr_reserv DESC");
                $recherche->execute(array($name,$auj));
                
                	echo' <div class="container-fluid">
          
		            <div class="card shadow mb-4">
		              <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">résultat de la recherche</h6></div>
		              <div class="card-body">
		                <div class="table-responsive">

		                  <table class="table table-bordered" id="" width="100%" cellspacing="0">
		                    <thead><tr><th>RESERVATION</th><th><span>DESIGNATION</span></th><th>date d\'arrivée</th><th>date de depart</th><th>Tel</th><th>Actions</th></tr></thead><tbody>';
		                    while($affreserve = $recherche->fetch())
                			{
		                    	 echo "
			                    <tr>
			                    <td><button class='collapsible btn btn-circle bg-gradient-info'><font color='white'><i class='fa fa-info'></i></font></button>
			                    <div class='content' style='display:none;'><p>apartement:  ".$affreserve[1]."<br>Montant(FCFA):  ".$affreserve[7]."<br>Objet:  ".$affreserve[11]."<br>Date:  ".$affreserve[3]."</p>
			                    </div>
			                    </td>
			                    <td>".$affreserve[1]."</td>
			                    <td>".$affreserve[2]."</td>
			                    <td>".$affreserve[3]."</td>
			                    <td>".$affreserve[13]."</td>
			                    <td>
			                    <button class='btn bg-gradient-info'>
			                    <a href='edit_reservation.php?id=".$affreserve[0]."&amp;clt=".$affreserve[9]."&amp;r=".$affreserve[11]."&amp;h=".$affreserve[10]."'><font color='white'><i class='fa fa-edit'></i></font>
			                    </a>
			                    </button>
			                    <button class='btn bg-gradient-primary'>
			                    <a href='buy.php?id=".$affreserve[0]."&amp;clt=".$affreserve[9]."&amp;r=".$affreserve[11]."&amp;h=".$affreserve[10]."'><font color='white'><i class='fas fa-dollar-sign'></i></font>
			                    </a>
			                    </button>
			                    <button class='btn bg-gradient-success'>
			                    <a href='../facture/impreservation.php?id=".$affreserve[0]."&amp;nc=".$affreserve[14]."&amp;pnc=".$affreserve[15]."&amp;datres=".$affreserve[8]."&amp;hres=".$affreserve[10]."&amp;j=".$affreserve[16]."&amp;s=".$affreserve[17]."&amp;a=".$affreserve[1]."&amp;m=".$affreserve[7]."&amp;datar=".$affreserve[2]."&amp;datdep=".$affreserve[3]."&amp;ob=".$affreserve[11]."'><font color='white'><i class='fa fa-print'></i></font>
			                    </a>
			                    </button>
			                    </td>
			                    </tr>
			                    ";
		                 	}    
		                  echo'</tbody></table>
		                </div>
		              </div>

		            </div> 
		          </div>';
		                   

               
                
           }
		                 
		           
		}

		public function getcustomer($firstname, $lastname)
		{
			require ('confige.php');
			$matricule = $bdd->query("SELECT SQL_NO_CACHE * FROM client WHERE nom_clt='".$firstname."' AND pnom_clt='".$lastname."' ");
            $ext = $matricule->fetch();
            return intval($ext[0]);
		}

		public function addcustommer($title, $firstname, $lastname, $tel, $email, $add)
		{
			require 'confige.php';
			//mettre le client dans la table
              
            $ajclient = $bdd->prepare("INSERT INTO client(id_clt, title, nom_clt, pnom_clt, tel, mail, address) VALUES(?, ?, ?, ?, ?, ?, ?) ");
            $ajclient->execute(array(NULL, $title, $firstname, $lastname, $tel, $email, $add));
		}

		public function name($id)
		{
			require 'confige.php';
			//nom du client
            $cl = $bdd->query("SELECT SQL_NO_CACHE nom_clt FROM client WHERE id_clt='".$id."' ");
            $clt = $cl->fetch();
            return $clt[0];
		}

		public function lastname($id)
		{
			require 'confige.php';
			//prenoms du client
            $cl = $bdd->query("SELECT SQL_NO_CACHE pnom_clt FROM client WHERE id_clt='".$id."' ");
            $clt = $cl->fetch();
            return $clt[0];
		}

		public function mod_customer($a, $b, $c, $d, $e, $id)
		{
			require 'confige.php';
			$prepare = $bdd->prepare('UPDATE client SET nom_clt=?, pnom_clt=?, tel=?, mail=?, address=? WHERE id_clt=?');
			$prepare->execute(array($a, $b, $c, $d, $e, $id));
		}		
	}

?>