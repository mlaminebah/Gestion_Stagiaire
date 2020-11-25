<?php
    session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    try {
        require_once("connBD.php");
        $log = isset ($_GET['log']) ? htmlentities(addslashes($_GET['log'])):"";
        //echo ($_SESSION['user']['login']) == $log;
        $req = "DELETE FROM Utilisateur WHERE login = '$log'";
        
        if ($base -> query ($req)) $errMessage = 0;
        else $errMessage = 1;
        if ($_SESSION['user']['login'] == $log) {
            header ("location:seDeconnecter.php");
        } else 
            header ("location:utilisateurs.php?errMessage=".$errMessage);
    } catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	} finally {
		$base = null;
	}
?>