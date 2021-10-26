<?php
	//ici est la classe qui gère les batiments

	class batiment
	{
		public function all_batiment()
		{
			require 'confige.php';
			$query = $bdd->query("SELECT SQL_NO_CACHE * FROM  batiment");
			return $query;
		}

		public function add_batiment($name)
		{
			require 'confige.php';
			//ajout de batiment
			$add = $bdd->prepare('INSERT INTO batiment(id_bat, lib_bat) VALUES (?, ?)');
			$add->execute(array(NULL,$name));
		}

		public function edit_batiment($name, $id)
		{
			require 'confige.php';
			//ajout de batiment
			$edit = $bdd->prepare('UPDATE batiment SET lib_bat =? WHERE id_bat=?');
			$edit->execute(array($name, $id));
		}
	}
?>