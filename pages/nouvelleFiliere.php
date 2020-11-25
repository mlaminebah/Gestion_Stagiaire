<?php session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
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
				<h6 style="margin-top:10px;margin-left:20px">Veuillez saisir les données de la nouvelle filière</h6>
			</div>
			<div class="container border" style="padding-bottom:40px">
				<form action="ajoutFiliere.php" method="post" name="search" onsubmit="return verif()">
				  <div class="form-group">
					<label for="nomFil" class="font-weight-bold">Nom Filière:</label>
					<input type="text" class="form-control" placeholder="Nom de la filière" id="nomFil" name="nomFil">
				  </div>
				  <div class="form-group">
					<label for="niveau" class="font-weight-bold">Niveau:</label>
					<select class="form-control form-control-sm" name="nivs" id="nivs" Placeholder="Tous les niveaux">
							<option></option>
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
				
					<?php
						if (isset($_GET['errMessage'])) {
							$message = $_GET['errMessage'];
							if ($message == 0) 
								echo "<h5 class=\"text-success\">Filière ajoutée avec succès</h5>";
							else if ($message == 2)
								echo "<h5 class=\"text-warning\">Filière Déjà ajoutée </h5>";
							else 
								echo "<h5 class=\"text-danger\>Ajout Filière Echec </h5>";
						}
					?>
					
				</h5>
			</div>
			<script>
				function verif () {
					var list = document.getElementById ('nivs');
					var val = list.options [list.selectedIndex].value;
					if (val == "" && document.search.nomFil.value == "") {
						alert ("Tous les champs ne doivent pas être vides");
						return false;
					}
					 return true;
				}
			</script>
	</body>
</html>

