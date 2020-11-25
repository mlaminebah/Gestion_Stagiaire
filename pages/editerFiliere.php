<?php
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
	require_once("connBD.php");
	$don = isset ($_GET['don']) ? htmlentities(addslashes($_GET['don'])):"";
	list($id,$nomF,$niv) = explode (';',$don);
	if (isset ($_POST['id']) && isset ($_POST['nomFil']) && isset ($_POST ['nivs'])) {
		
		$id = htmlentities(addslashes($_POST['id']));
		$nomFil = htmlentities(addslashes($_POST['nomFil']));
		$nivs = htmlentities(addslashes($_POST['nivs']));
		if (!empty ($id) && !empty ($nomFil) && !empty ($nivs)) {
			
			$req = "UPDATE Filiere SET nomFiliere =:nf,niveau =:niv WHERE IdFiliere =:id";
			$res = $base -> prepare ($req);
			$res->bindParam (':nf',$nomFil);
			$res->bindParam (':id',$id);
			$nivs = strtoupper ($nivs);
			$res->bindParam (':niv',$nivs);
			if ($res->execute ()) $errMessage = 0;
			else $errMessage = 1;
			header ("location:filieres.php?errMessage=".$errMessage);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>Gestion des Stagiaires</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include ('menu.php');?>
		<div class="container border bg-info text-white" style="margin-top:40px">
			<h6 style="margin-top:10px;margin-left:20px">Edition de la Filière</h6>
		</div>
		<div class="container border" style="padding-bottom:40px">
			<form action="editerFiliere.php" name="search" id="search" onsubmit="return verif ()" method="POST">
				  <div class="form-group">
					<label for="nomFil" class="font-weight-bold">Id Filière:</label>
					<input type="text" class="form-control" value="<?php echo $id;?>" readonly="true" name="id">
				  </div>
				  <div class="form-group">
					<label for="nomFil" class="font-weight-bold">Entrez le nouveau Nom:</label>
					<input type="text" class="form-control"  id="nomFil" name="nomFil" value="<?php echo $nomF;?>">
				  </div>
				  <div class="form-group">
					<label for="niveau" class="font-weight-bold">Entrez le noouveau Niveau:</label>
					<select class="form-control form-control-sm" name="nivs" id="nivs" Placeholder="Tous les niveaux">
							<option><?php echo $niv;?></option>
							<option value="all">Tous les niveaux</option>
							<option value="l">Licence</option>
							<option value="m">Master</option>
							<option value="d">Doctorat</option>
							<option value="q">Qualification</option>
							<option value="ts">Technicien Spécialisé</option>
							<option value="t">Technicien</option>
					</select>
				  </div>
				  <button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-down"></i> Enregistrer</button>
			</form>
		</div>
		<script type="text/javascript">
			
    		function verif () {
				var position = window.location.href.indexOf('=');
				var don = window.location.href.substr(position + 1);
				var don = don.split (";");
				var niv = don [2],nomF = don [1];
				//console.log (nomF);
				var list = document.getElementById ('nivs');
				var val = list.options [list.selectedIndex].value;
				if (val == "" && document.search.nomFil.value == "") {
					alert ("Tous les champs ne doivent pas être vides");
					return false;
				}
				if (val == niv && nomF == search.nomFil.value) {
					alert ("Un des champs au moins doit être modifié");
					return false;
				}
					
			 return true;
		  }
		</script>
	</body>
</html>
