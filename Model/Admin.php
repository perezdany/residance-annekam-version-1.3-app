<?php
	//ici est la classe de l'objet admin

	class admin
	{
		public function add_admin($pseudo, $mdp, $type)
		{
			require 'confige.php';
			$add = $bdd->prepare("INSERT INTO admin(id_admin, pseudo, mdp, type) VALUES (?, ?, ?, ?)");
			$add->execute(array(NULL, $pseudo, $mdp, $type));
		}

		public function all_admin()
		{
			require 'confige.php';
			$see = $bdd->query("SELECT SQL_NO_CACHE * FROM admin");
			return $see;
		}


		public function edit_admin($pseudo, $mdp, $id)
		{
			require 'confige.php';
			$edit = $bdd->prepare("UPDATE `admin` SET pseudo=?, mdp=? WHERE id_admin=?");
			$edit->execute(array($pseudo, $mdp, $id));
			
		}
	}

?>