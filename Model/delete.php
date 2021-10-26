<?php

    //Code pour les suppressions

//Sppresion de reservation
     function delete_reserv()
    {

        require 'confige.php';
        
        if(isset($_POST['delres']))
        {
            $id = htmlspecialchars($_POST['id']);
            $rsup = $bdd->query("DELETE FROM reservation WHERE id_reserv ='".$id."'");
            
            $fsup =$bdd->query("DELETE FROM facture WHERE id_reserv ='".$id."' ");
            
           header('location:../admin/reservation.php');
            
        }

        if(isset($_POST['delresh']))
        {
            $id = htmlspecialchars($_POST['id']);
            $rsup = $bdd->query("DELETE FROM reservation WHERE id_reserv ='".$id."'");
            
            $fsup =$bdd->query("DELETE FROM facture WHERE id_reserv ='".$id."' ");
            
           header('location:../admin/reserv_history.php');
            
        }
    }

//supression client
      function delete_customer()
    {

        require 'confige.php';
        
        if(isset($_POST['delcus']))
        {
            $id = htmlspecialchars($_POST['id']);
            $csup = $bdd->query("DELETE FROM client WHERE id_clt ='".$id."'");
            $rsup =$bdd->query("DELETE FROM reservation WHERE id_clt ='".$id."'");
            $id_res = $bdd->query("SELECT r.id_reserv FROM reservation r, client c WHERE r.id_clt=c.id_clt ");
            while($r = $id_res->fetch())
            {
                $fsup =$bdd->query("DELETE FROM facture WHERE id_reserv ='".$r[0]."'");
            }
           
            
           header('location:../admin/customer.php');
            
        }
    }
//suppression facture
      function delete_facture()
    {

        require 'confige.php';
        
        if(isset($_POST['delf']))
        {
            $id = htmlspecialchars($_POST['id']);
            $fsup = $bdd->query("DELETE FROM facture WHERE id_fact ='".$id."'");
            header('location:../admin/fact.php');
            
        }
    }


//suppression entretien
      function delete_recovery()
    {

        require 'confige.php';
        
        if(isset($_POST['delrec']))
        {
            $id = htmlspecialchars($_POST['id']);
            $esup = $bdd->query("DELETE FROM entretien WHERE id_ent ='".$id."'");
            header('location:../admin/recoveries.php');
            
        }
    }
// suppression appartement
      function delete_appart()
    {

        require 'confige.php';
        
        if(isset($_POST['delap']))
        {
            $id = htmlspecialchars($_POST['id']);
            $asup = $bdd->query("DELETE FROM appartement WHERE id_appart ='".$id."'");
            $lsup = $bdd->query("DELETE FROM lit l, appartment a WHERE a.id_appart=l.id_appart AND id_appart ='".$id."'");
            header('location:../admin/appartment.php');
            
        }
    }

//suppression batiment
      function delete_bat()
    {

        require 'confige.php';
        
        if(isset($_POST['delbat']))
        {
            $id = htmlspecialchars($_POST['id']);
            $asup = $bdd->query("DELETE FROM batiment WHERE id_bat ='".$id."'");
            header('location:../admin/batiment.php');
            
        }
    }
 
 //suppression de lits
      function delete_bed()
    {

        require 'confige.php';
        
        if(isset($_POST['delbed']))
        {
            $id = htmlspecialchars($_POST['id']);
            $asup = $bdd->query("DELETE FROM lit WHERE id_lit ='".$id."'");
            header('location:../admin/bed.php');
            
        }
    }

//Suppression admins

      function delete_admin()
    {

        require 'confige.php';
        
        if(isset($_POST['dela']))
        {
            $id = htmlspecialchars($_POST['id']);
            $asup = $bdd->query("DELETE FROM admin WHERE id_admin ='".$id."'");
            header('location:../admin/admin.php');
            
        }
    }


    //appel des fonctions
    delete_reserv();
    delete_customer();
    delete_facture();
    delete_recovery();
    delete_appart();
    delete_bat();
    delete_admin();