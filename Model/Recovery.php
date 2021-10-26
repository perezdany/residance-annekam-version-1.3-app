<?php
	//ici est la classe qui va gérer les entretiens

	class recovery
	{
		public function all_recoveries()
		{
			//affihcer l'ensemble des operations d'entretien
			require 'confige.php';
	        $ent = $bdd->query("SELECT SQL_NO_CACHE e.lib_ent, e.mont_entretien, e.dat_op, a.lib_appart, e.mont_entretien, e.id_ent FROM entretien e, appartement a WHERE e.id_appart=a.id_appart");
	        return $ent;
	      //faire en haut de la page un calcul pour le total des dépenses
		}

		public function addrecovery($id, $lib, $app, $nd, $mont)
		{
			require 'confige.php';
			// traitment d'ajout de l'entretien
			//insertion dans la base
            $mettre = $bdd->prepare("INSERT INTO entretien(id_ent, lib_ent, id_appart, dat_op, mont_entretien) VALUES (?, ?, ?, ?, ?)");
            $execute = $mettre->execute(array($id, $lib, $app, $nd, $mont));
        }

        public function months_recoveries($month, $year)
        {

        	require 'confige.php';
        	//affichier ici les requetes du mois
        	$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);// nombre de jour du mois
        	$dd = $year."-".$month.'-01';
			$df = $year."-".$month.'-'.$number;
        	$query = $bdd->query("SELECT SQL_NO_CACHE e.lib_ent, e.mont_entretien, e.dat_op, a.lib_appart, e.mont_entretien, e.id_ent FROM entretien e, appartement a WHERE e.id_appart=a.id_appart  AND e.dat_op BETWEEN '".$dd."' AND '".$df."' ");
            while($fen = $query->fetch())
	        {
	        	$timestampd = strtotime($fen[2]);//recuperation du timestanp de la date donnée
				$new_format1 = date("d/m/Y", $timestampd);//changement du format
	        	echo'<tr><td>'.$fen[3].'</td><td style="width:450px">'.$fen[0].'</td><td>'.$new_format1.'</td><td >'.number_format($fen[1], 0, ',', ' ').'</td><td><form method="post" action="../Model/delete.php"><input type="text" value="'.$fen[5].'" style="display: none;" name="id"><button class="btn btn-circle bg-gradient-danger" type="submit" name="delrec"><font color="white"><i class="fa fa-trash"></i></font></button></form></td></tr>';
	        }

        }
	}

?>