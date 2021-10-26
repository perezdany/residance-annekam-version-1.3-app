<?php
	//ici est la classe qui va gerer les factures

	class facture
	{ 
		public function insertfact($a, $b, $c, $d, $e, $f, $g)
		{
			require 'confige.php';
			$insert = $bdd->prepare("INSERT INTO facture(id_fact, mont_sur_fact, id_reserv, dat_emi, rest_a_pay, hr_emi, s, id_pay) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$insert->execute(array($a, $b, $c, $d, $e, $f, 1, $g));
			// la variable g pour le mode de payement
		}


		public function insertfact0($a, $b, $c, $d, $e, $f)
		{
			$g = 4; // ici on fixe le g a 4C car on n'est incertain du mode de payement
			require 'confige.php';
			$insert = $bdd->prepare("INSERT INTO facture(id_fact, mont_sur_fact, id_reserv, dat_emi, rest_a_pay, hr_emi, s, id_pay) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->execute(array($a, $b, $c, $d, $e, $f, 0, $g));
		}


		public function all_fact()
		{
			require 'confige.php';
			//affichage des factures
			$f = $bdd->query("SELECT SQL_NO_CACHE f.id_fact, f.mont_sur_fact, r.id_reserv, f.dat_emi, f.rest_a_pay, f.hr_emi, f.s, a.tar_jour, a.lib_appart, r.mont_reserv, r.nb_jr, a.tar_mois, c.nom_clt, c.pnom_clt, r.dat_reserv, r.statut FROM facture f, reservation r, client c, appartement a WHERE c.id_clt=r.id_clt AND r.id_reserv=f.id_reserv AND r.id_appart=a.id_appart AND r.statut=1 AND f.rest_a_pay=0  ORDER BY dat_emi DESC, hr_emi DESC ");
          	return $f;
		}

		public function update_s($a)
		{
			require 'confige.php';
			//traitement pour mettre a jour la facture en tant que facture payée
			//on modifie la base de données c'ets a dire la facture en question
			$update = $bdd->query('UPDATE facture SET s="1" WHERE id_fact="'.$a.'"');
		}
	}
?>