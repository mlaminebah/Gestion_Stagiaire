<?php
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
	require_once("connBD.php");
	$id = isset ($_GET['id'])?htmlentities(addslashes($_GET['id'])):"";
	//s'il y a un stagiaire inscrit dans cette filière on ne peut la supprimer
	//on gère d'abord cela
	$req = "SELECT COUNT(*) nb FROM Stagiaire WHERE IdFiliere = $id";
	$res = $base->query ($req);
	$resf = $res->fetch ();
	$nb = $resf['nb'];
	if ($nb==0) {
		//echo $id."<br>";
		$req = "DELETE FROM Filiere WHERE IdFiliere = $id";
		if ($base -> query ($req)) $errMessage = 2;
		else $errMessage = 3;
	} else {
		$errMessage = 4;
	}
	header ("location:filieres.php?errMessage=".$errMessage);
	
?>
