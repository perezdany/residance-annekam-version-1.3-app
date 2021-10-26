<?php
	
	//ici est la classe qui va gérer les action sur la base de données
	
	class base_data
	{
		public function export()
		{
			require 'confige.php';
		    // recuperer tutes les tables de base
		    $tables = $bdd->query('SHOW TABLES from appart');

		    //creation et ouverture du fichier
		    $fichier  = fopen("../bdd/appart.sql", "w+");// on ouvre le fichier en ecriture donc w et r pour lire
		    fclose($fichier); // si le fichier existe , cela va permettre d' écraser l'ancien
		    $fichier  = fopen("../bdd/appart.sql", "w+");//accès en ecriture sans écraser les anciennes infos
		    $chaine = "" . PHP_EOL;//on crée une variables qui va recupérer les infos a chaque fois pour mettre dans le fichier
		    //ecriure des infos en debut du fichier sql
		    /*$chaine .= "--phpMyAdmin SQL Dump". PHP_EOL ;
		    $chaine .= "--version 4.9.2". PHP_EOL;
		    $chaine .= "-- https://www.phpmyadmin.net/". PHP_EOL;//php_eol pour aller a la ligne
		    $chaine .= "--". PHP_EOL;
		    $a = gethostbyname('localhost');//adresse ip du localhost
		    $chaine .= utf8_decode("--Hôte : ".$a.":3306". PHP_EOL);
		    //la date en francais
		    setlocale(LC_TIME, 'fra_fra');
		    $d = strftime('%A %d %B %Y');
		    $h = strftime('%H:%M');
		    $chaine .= utf8_decode("--Généré le : ".$d." à ".$h."". PHP_EOL);

		    $attributes = array(
		     "SERVER_VERSION"
		    );

		    foreach ($attributes as $val) {
		       $ser_vers = $bdd->getAttribute(constant("PDO::ATTR_$val")) . "\n";
		    }
		    $chaine .= "--Version du serveur :  ".$ser_vers."". PHP_EOL;//version du serveur

		    $php_ver = phpversion(); //version du php
		    $chaine .= "--Version de PHP :  ".$php_ver."". PHP_EOL;*///version du serveur

		    $chaine .= 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'. PHP_EOL; 
		    $chaine .= "SET AUTOCOMMIT = 0;". PHP_EOL; 
		    $chaine .= "START TRANSACTION;". PHP_EOL; 
		    $chaine .= 'SET time_zone = "+00:00";'. PHP_EOL; 

		    $chaine .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;". PHP_EOL; 
		    $chaine .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;". PHP_EOL; 
		    $chaine .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;". PHP_EOL; 
		    $chaine .= "/*!40101 SET NAMES utf8mb4 */;". PHP_EOL; 

		    $chaine .= "--". PHP_EOL;
		    $chaine .= utf8_decode("-- Base de données :  `appart`". PHP_EOL); 
		    $chaine .= "--". PHP_EOL;

		    $chaine .= "-- --------------------------------------------------------". PHP_EOL;

		    //traitement pour les tables maintenants



		    while($tables_res = $tables->fetch())
		    {

		      //struture de la table 
		      $chaine .= "--". PHP_EOL;
		      $chaine .= "-- Structure de la table `".$tables_res[0]."`". PHP_EOL; 
		      $chaine .= "--". PHP_EOL;
		      $chaine .= "DROP TABLE IF EXISTS `".$tables_res[0]."`;". PHP_EOL;
		      $chaine .= "CREATE TABLE IF NOT EXISTS `".$tables_res[0]."`(". PHP_EOL;//tout ca ce sont les instructions sql pour créer les tables
		      
		      $structure = $bdd->query("DESCRIBE ".$tables_res[0]."");
		      while($aff_st = $structure->fetch())
		      { 
		        if($aff_st[5] == "auto_increment")
		        {
		          $chaine .= "`".$aff_st[0]."` ".$aff_st[1]." NOT NULL AUTO_INCREMENT,". PHP_EOL;
		        }
		        else
		        {
		          $chaine .= "`".$aff_st[0]."` ".$aff_st[1]." NOT NULL,". PHP_EOL;
		        }
		      }
		        
		      //on va faire une autre boucle pour affihce les clés primaire et etrangères
		      $strange_key = 0;
		      $strange_keyc = 1;
		     //on va compter le nombre de clé étrangère d'abord
		      $k = $bdd->query("DESCRIBE ".$tables_res[0]."");
		      while($aff = $k->fetch())
		      {
		        if($aff[3] == "MUL")//clé etrangère
		        {
		          $strange_key ++;
		        }
		      }
		      
		      //on ecrit maintenant
		      $k = $bdd->query("DESCRIBE ".$tables_res[0]."");
		      while($aff = $k->fetch())
		      { 
		        
		        if($aff[3] == "PRI")//clé primaire
		        {
		          if($strange_key > 0)
		          {
		            $chaine .= "PRIMARY KEY (`".$aff[0]."`),". PHP_EOL;
		          }
		          else
		          {
		              $chaine .= "PRIMARY KEY (`".$aff[0]."`)". PHP_EOL;
		          }
		            
		        }
		        
		        if($aff[3] == "MUL")//clé etrangère
		        {
		          
		          if($strange_keyc == $strange_key)//clé etrangère
		          {
		            $chaine .= " KEY `".$aff[0]."` (`".$aff[0]."`)";
		          }
		          else
		          {
		            $chaine .= " KEY `".$aff[0]."` (`".$aff[0]."`),";
		            $strange_keyc ++;
		          }
		        }
		          
		         
		      }
		      $chaine .= ")". PHP_EOL;

		      //on va parcourir pour afficher les infos sur le moteur et sur le jeu de caracteres
		      $last_id = 0; //on initailise une variable à 0 pour recevoir le dernier id
		      $infos = $bdd->query("DESCRIBE ".$tables_res[0]."");
		      $aff = $infos->fetch();
		      if($aff[5] == "auto_increment")//incrementation automatique
		      {
		       //on ecrit la requete pour prendre le dernier identifiant en vu de faire +1
		        $q = $bdd->query("SELECT ".$aff[0]." FROM ".$tables_res[0]." order BY ".$aff[0]." DESC limit 1");
		        $id = $q->fetch();
		        $last_id = $id[0];
		      
		      }
		      else
		      {
		        
		      }
		      
		      
		      if($last_id > 0)//ca veut dire que y a un identifient qui est auto_increment
		      {
		        $chaine .= "ENGINE=InnoDB AUTO_INCREMENT=".($last_id+1)." DEFAULT CHARSET=utf8;". PHP_EOL;
		      }
		      else
		      {
		        $chaine .= "ENGINE=InnoDB DEFAULT CHARSET=utf8;". PHP_EOL;
		      }
		      
		      //mais on va verifier si d'abord y des données avant de decharger
		      $data = $bdd->query("SELECT * FROM ".$tables_res[0]."");
		      $fetchall = $data->fetchAll();
		      $c = count($fetchall);
		      if($c == 0)
		      {

		      }
		      else
		      {
		            //code pour le dechargement des données de chaque table maintenant
		          $chaine .= "--". PHP_EOL;
		          $chaine .= utf8_decode("-- Déchargement des données de la table `".$tables_res[0]."`". PHP_EOL); 
		          $chaine .= "--". PHP_EOL;

		          // on va recuperer les champs de la table
		          $compte = 1;
		          $fields = $bdd->query("show fields from ".$tables_res[0]."");
		          $f = $fields->fetchAll();
		          $nb_fields = count($f);
		          $chaine .= "INSERT INTO `".$tables_res[0]."` (";
		          //refaire la requete pour ecrire dans la parenthèse
		          $fields = $bdd->query("show fields from ".$tables_res[0]."");
		          while($champs = $fields->fetch())
		          {
		            if($compte == $nb_fields)//pour voir si on est arrivé au dernier champ
		            {
		              $chaine .= "`".$champs[0]."`)";
		            }
		            else
		            {
		              $chaine .= "`".$champs[0]."`,";
		            }
		            $compte ++;
		          }
		          $chaine .= " VALUES";

		          //faire comme la boucle precedente mais cette fois ci c'est les données de la table
		          
		          $data = $bdd->query("SELECT * FROM ".$tables_res[0]."");
		          $fetch = $data->fetchAll();
		          $row = count($fetch);//nombre de lignes
		          $n = $row - 1;
		          $data = $bdd->query("SELECT * FROM ".$tables_res[0]."");
		          $all = $data->columnCount();//nombre colomnes
		          $ri = 1;

		          $tab = array();
		          $k = $bdd->query("DESCRIBE ".$tables_res[0]."");// on va travailler avec chaque type des champs donc on les mets dans tab
		          $f = $k->fetchAll();
		          $nb_fields = count($f);
		          $i = 0;
		          while($o = $k->fetch())
		          {
		            while($i <  $nb_fields)
		            {
		              $tab[$i] = $o[1];
		            }
		            $i++;
		          }

		          $data = $bdd->query("SELECT * FROM ".$tables_res[0]."");
		          while($r = $data->fetch())
		          {
		            $chaine .= " (";//on ouvre la parenthese
		            for($i = 0; $i<$all; $i++ )
		            {
		              if($i == ($all-1))
		              {
		                if($i == ($all-1) AND $ri == $row)  
		                {
		                  if(gettype($r[$i]) == 'string')
		                  {
		                    $chaine .= utf8_decode("'".$r[$i]."');". PHP_EOL);//on ferme la parenthese et on met la valeur en double quote car c'est string
		                  }
		                  else
		                  {
		                    $chaine .= utf8_decode("'".$r[$i]."');". PHP_EOL);//on ferme la parenthese
		                  }
		                  
		                }         
		                else
		                {
		                  if(gettype($r[$i]) == 'string')
		                  {
		                    $chaine .= utf8_decode("'".$r[$i]."'),". PHP_EOL);//on ferme la parenthese
		                  }
		                  else
		                  {
		                    $chaine .= utf8_decode("'".$r[$i]."'),". PHP_EOL);//on ferme la parenthese
		                  }
		                  
		                }
		                
		              }
		              else
		              {
		                if(gettype($r[$i]) == 'string')
		                {
		                  $chaine .= utf8_decode("'".$r[$i]."',");
		                }
		                else
		                {
		                  $chaine .= utf8_decode($r[$i].",");
		                }
		                
		              }
		              
		            }
		           $ri ++;
		          }
		          
		         $chaine .= "-- --------------------------------------------------------". PHP_EOL;
		        }
		    

		      }
		      
		    //on passe au contraintes maintenant
		    /*$chaine .= "--". PHP_EOL;
		    $chaine .= utf8_decode("-- Contraintes pour les tables déchargées". PHP_EOL); 
		    $chaine .= "--". PHP_EOL;

		    $foreing_key = array();
		    $contraintes = $bdd->query("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE `table_schema` LIKE 'appart' AND `constraint_type` = 'FOREIGN KEY'");
		    while($res = $contraintes->fetch())
		    {
		      $chaine .= "--". PHP_EOL;
		      $chaine .= "-- Contraintes pour la table `".$res[4]."`". PHP_EOL; 
		      $chaine .= "--". PHP_EOL;


		      $chaine .= 'ALTER TABLE `'.$res[4].'`'. PHP_EOL;
		      $c = $bdd->query("DESCRIBE ".$res[4]."");
		      $i = 0;
		      while($v = $c->fetch())
		      {
		        if($v[3] == "MUL")
		        {
		          $foreing_key[$i] = $v[0];
		          $i++;
		        }
		      }
		      for ($a = 0; $a < count($foreing_key); $a++)
		      {
		        if($a == count($foreing_key))
		        {
		          $chaine .= 'ADD CONSTRAINT `'.$res[2].'` FOREIGN KEY (`'.$foreing_key[$a].'`) REFERENCES `'.$res[4].'` (`'.$foreing_key[$a].'`) ON DELETE CASCADE ON UPDATE CASCADE'. PHP_EOL;
		        }
		        else
		        {
		          $chaine .= 'ADD CONSTRAINT `'.$res[2].'` FOREIGN KEY (`'.$foreing_key[$a].'`) REFERENCES `'.$res[4].'` (`'.$foreing_key[$a].'`) ON DELETE CASCADE ON UPDATE CASCADE,'. PHP_EOL;
		        }
		        
		      }
		      $chaine .= ';'. PHP_EOL;
		    }*/

		    $chaine .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;". PHP_EOL; 
		    $chaine .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;". PHP_EOL; 
		    $chaine .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;". PHP_EOL; 
		  
		    fwrite($fichier,$chaine."\r\n");
		    fclose($fichier);
		   
		    
		}
	}

?>