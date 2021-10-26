<?php
	session_start();
	//creation de la procedure de traitement de recherche de mois

	 function treat()
	 {
	    if(!empty($_POST['month']) AND !empty($_POST['year']) )
	    {
	      $month = $_POST['month'];
	      $year = $_POST['year'];
	      $_SESSION['month'] = intval($month);
	      $_SESSION['year'] = intval($year);

	      $num_mois = date('n'); // numero du mois
	      $num_an = date('Y'); //l'an
	      //verification pour voir si les mois et années entrés correspondent
	      if(intval($num_an) < intval($year))//l'annee la est superieur a l'année
	      {
	        header("location:month_recoveries.php?error=Désolé! Tableau introuvable!");
	        
	      }
	      else
	      {
	        $_SESSION['month'] = intval($month);
	        $_SESSION['year'] = intval($year);
	        
	        header("location:old_month_recoveries.php");
	        //echo'<font color="green"><h4>Cliquer sur ce bouton <a href="old_table.php"><button class="btn-primary" type="" style="border-radius: 10px; width:100px">voir</button></a> pour voir le tableau:</h4></font>';
	      }
	    }
	    else
	    {
	      
	      header("location:month_recoveries.php?error=Veuillez Remplir les champs svp!");
	    }
   }


   treat();
?>