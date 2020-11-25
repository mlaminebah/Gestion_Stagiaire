<?php
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
	try { 
		require_once("connBD.php");
		$nomFil = isset($_POST['nomFil'])?htmlentities(addslashes($_POST['nomFil'])):"";
		$niveau = isset($_POST['nivs'])?htmlentities(addslashes($_POST['nivs'])):"";
		
		$sql = "SELECT *FROM Filiere WHERE nomFiliere = :nf AND niveau = :niv";
		$res = $base -> prepare ($sql);
		$res->bindParam (':nf',$nomFil);
		$res->bindParam (':niv',$niveau);
		if ($res->execute () == FALSE) $errMessage = 1;
		if ($res->rowCount () != 0) $errMessage = 2;
		else {
			$sql1 = "INSERT Filiere (nomFiliere,niveau) VALUES (:nf,:niv)";
			$res2 = $base -> prepare ($sql1);
			$res2->bindParam (':nf',$nomFil);
			$niveau = strtoupper ($niveau);
			$res2->bindParam (':niv',$niveau);
					
			if ($res2->execute () == FALSE) $errMessage = 1;
			else $errMessage = 0;
		}
		header ("location:nouvelleFiliere.php?errMessage=".$errMessage);
	} catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	}finally {
		$base = null;
	}
?>
