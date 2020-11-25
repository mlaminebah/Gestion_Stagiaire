<?php
    session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    try {
        require_once("connBD.php");
        $log = isset ($_GET['log']) ? htmlentities(addslashes($_GET['log'])):"";
        $etat = isset ($_GET['etat']) ? htmlentities(addslashes($_GET['etat'])):0;
        $netat = $etat == 0 ? 1 : 0;
        $req = "UPDATE Utilisateur SET etat = '$netat' WHERE login = '$log'";
        if ($base->query($req)) {
            
            if ($netat == 0 && $_SESSION['user']['login'] == $log)
               header ("location:seDeconnecter.php");
            else    
               header ("location:utilisateurs.php"); 
        } else 
            header ("location:utilisateurs.php?errMessage='4'");
    } catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	}finally {
		$base = null;
	}
?>