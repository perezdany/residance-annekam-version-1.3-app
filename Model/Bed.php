<?php

	//ici est la classe qui gère les lits

	class bed
	{
		public function addbed($nb, $bat)
		{
			require 'confige.php';
			//ajout de lit
			$add = $bdd->prepare('INSERT INTO lit(id_lit, nb_place, id_appart) VALUES (?, ? ,?)');
			$add->execute(array(NULL, $nb, $bat));
		}

		public function allbed()
		{
			require 'confige.php';
			//affichages des lits
			$query = $bdd->query("SELECT SQL_NO_CACHE l.id_lit, l.nb_place, a.lib_appart, a.id_appart FROM lit l, appartement a WHERE a.id_appart=l.id_appart");
          	return $query;
		}

		public function edit_bed($nb, $bat, $id)
		{
			require 'confige.php';
			//ajout de lit
			$edit = $bdd->prepare('UPDATE lit SET nb_place = ?, id_appart =? WHERE id_lit=?');
			$edit->execute(array($nb, $bat, $id));
		}
	}
?>