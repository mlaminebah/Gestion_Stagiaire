<?php
    session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    try {
        require_once("connBD.php");
        $id = isset ($_GET['id'])?htmlentities(addslashes($_GET['id'])):"";
        $req = "DELETE FROM Stagiaire WHERE IdStagiaire = $id";
        if ($base -> query ($req)) $errMessage = 0;
        else $errMessage = 1;
        header ("location:stagiaires.php?errMessage=".$errMessage);
    } catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	} finally {
		$base = null;
	}
?>
