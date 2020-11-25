<?php
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
	try { 
		require_once("connBD.php");
		$nbr = 0;
		$nomFil = isset($_GET['nomFil'])?htmlentities(addslashes($_GET['nomFil'])):"";
		$nivs = isset($_GET['nivs'])?htmlentities(addslashes($_GET['nivs'])):"all";
		$limite = isset($_GET['limite'])?$_GET['limite']:6;
		$page = isset($_GET['page']) ? $_GET['page']:1;
		$start = ($page-1) * $limite;
		//$requete = "SELECT *FROM Filiere";
		//$resultat = $base -> query ($requete);
		if (isset ($nomFil) && isset ($nivs)) {
			
			if (!empty($nomFil) && !empty ($nivs)) {
				$requete = "SELECT *FROM Filiere WHERE nomFiliere Like '%$nomFil%' AND niveau = :n LIMIT $start,$limite";
				$resultat = $base -> prepare ($requete);
				$resultat->bindParam (':n',$nivs);
				$resultat->execute ();
				$requeteCount = "SELECT *FROM Filiere WHERE nomFiliere Like '%$nomFil%' AND niveau = :n LIMIT $start,$limite";
				$res = $base-> prepare ($requeteCount);
				$res->bindParam (':n',$nivs);
				$res->execute ();
				$nbr = $resultat->rowCount ();
			} else if (!empty($nomFil) && empty ($nivs)) {
				$requete = "SELECT *FROM Filiere WHERE nomFiliere LIKE '%$nomFil%' LIMIT $start,$limite";
				$resultat = $base -> query ($requete);
				$requeteCount = "SELECT *FROM Filiere WHERE nomFiliere LIKE '%$nomFil%'";
				$res = $base -> query ($requeteCount);
				$nbr = $res ->rowCount ();
			} else if (empty ($nomFil) && !empty ($nivs)){
				if ($nivs == "all") {
					 $requete = "SELECT *FROM Filiere LIMIT $start,$limite";
					 $resultat = $base -> query ($requete);
					 $requeteCount = "SELECT *FROM Filiere";
					 $res = $base -> query ($requeteCount);
					 $nbr = $res->rowCount ();
					 
				} else {
					$nivs = strtoupper ($nivs);
					//echo $nivs;
					$requete = "SELECT *FROM Filiere WHERE niveau = :n LIMIT $start,$limite";
					$resultat = $base -> prepare ($requete);
					$resultat->bindParam (':n',$nivs);
					$resultat->execute ();
					$requeteCount = "SELECT *FROM Filiere WHERE niveau = :n";
					$res = $base-> prepare ($requeteCount);
					$res->bindParam (':n',$nivs);
					$res->execute ();
					$nbr = $res->rowCount ();
				}
				
			}
		}
		$reste = $nbr%$limite;
		$nbrPage = $reste == 0 ? ($nbr/$limite):floor($nbr/$limite) + 1;
		
	} catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	}finally {
		$base = null;
	}
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>Gestion des Stagiaires</title>
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
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php
			include ('menu.php');
		?>
		
		<div class="container border" style="margin-top:30px;padding-bottom:15px">
			<div class="row bg-success text-white">
				<h6 style="margin-top:10px;margin-left:20px">Recherche de Filières</h6>
			</div>
			<div class="row" style="margin-top:30px;margin-left:20px">
				<div class="col-7">
					<form class="form-inline" method="GET" name="search" onsubmit="return verif()">
						<input type="text" class="form-control form-control-sm" placeholder="Entrer un mot clé" name="nomFil" id="nomFil">
						<label for="niveau" class="font-weight-bold">Niveau</label>
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
						<button type="submit" name="search" id="search" class="btn btn-success">
							<i class="fas fa-search"></i>Rechercher
						</button>
					</form>
				</div>
				<?php if ($_SESSION['user']['role'] == "Admin") {?>
					<div class="col-5">
					<a href="nouvelleFiliere.php" class="nav-link"><i class="fas fa-plus"></i> Ajout Filière</a>
					</div>
				<?php }?>
			</div>
		</div>
		<div class="container border bg-info text-white" style="margin-top:40px">
			<h6 style="margin-top:10px;margin-left:20px">Liste des filières (<?php if (isset($nbr)) echo $nbr;?> Filière(s))</h6>
		</div>
		<div class="container border" style="padding-bottom:40px">
			<table class="table table-striped table-hover">
				<thead class="bg-muted">
					<tr>
						<th><?php echo strtoupper("id") ;?></th>
						<th><?php echo strtoupper("nom de la filiere") ;?></th>
						<th><?php echo strtoupper("niveau") ;?></th>
						<?php if ($_SESSION['user']['role'] == "Admin") {?>
						<th><?php echo strtoupper("actions") ;?></th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
						while ($donnees=$resultat->fetch()) {
							$id = $donnees['IdFiliere'];
							$nomF = $donnees['nomFiliere'];
							$niv = $donnees ['niveau'];
							echo "<tr>";
								echo "<td>".$id."</td>";
								echo "<td>".$nomF."</td>";
								echo "<td>".$niv."</td>";
								echo "<td>";
								if ($_SESSION['user']['role'] == "Admin") {
									echo "<a href=\"editerFiliere.php?don=$id;$nomF;$niv\" onclick=
									\" return confirm('Attention voulez vous vraiment le modifier')\">
									<i class=\"fas fa-wrench\"></i></a>";
									echo "<a href=\"supFiliere.php?id=$id\" onclick=
									\" return confirm('Attention voulez vous vraiment le supprimer?')\"\">
									<i class=\"fas fa-cut\" style=\"margin-left:20px\"></i></a>";
									echo "</td>";
								}
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<div class="container-fluid">
					<ul class="pagination">
						<li class="page-item">
						<?php 
							$nomFilf = isset($_GET['nomFil'])?htmlentities(addslashes($_GET['nomFil'])):"";
							$nivss = isset($_GET['nivs'])?htmlentities(addslashes($_GET['nivs'])):"all";
							echo "<select id =\"sel\" class=\"form-control form-control-sm\" Placeholder=\"N°Page\" 
							onchange=\"changeURL(this.value,'$nomFilf','$nivss')\">";?>
									<option value=""><?php echo "Page N° ".$page."/".$nbrPage; ?></option>
								<?php
									for ($i = 1; $i <= $nbrPage ; $i ++)
									 echo "<option value=\"$i\">$i</option>";
								?>
								</select>
						</li>
						<li class="page-item <?php if($page == 1) echo "disabled";?>"> 
							<a class="page-link" href="filieres.php?page=
							<?php if (($page - 1) > 0) echo $page - 1;else echo 1;?>&nomFil=
							<?php echo $nomFil;?>&nivs=<?php echo $nivs;?>">Previous</a>
						</li>
						<?php
							for ($i=1 ; $i <= ($nbrPage/2);$i ++) {?>
								<li class="page-item <?php if ($page == $i) echo "active";?>">
									<a class="page-link" href="filieres.php?page=
									<?php echo $i; ?>&nomFil=<?php echo $nomFil;?>&nivs=<?php echo $nivs;?>"><?php echo $i;?></a>
								</li>
						<?php
							}?>
						</li>
						<li class="page-item <?php if ($page > ($nbrPage/2) && $page + 1 <= $nbrPage) echo "active";else if ($page ==  $nbrPage) echo "disabled";?>">
							<a class="page-link" href="filieres.php?page=
							<?php if (($page + 1) <= $nbrPage) echo ($page + 1); else $page;?>&nomFil=
							<?php echo $nomFil;?>&nivs=<?php echo $nivs;?>">Next</a>
						</li>
					</ul>
					<?php
						if (isset($_GET['errMessage'])) {
							$message = $_GET['errMessage'];
							if ($message == 0) 
							   echo "<h5 class=\"text-success\">Modification Réussie</h5>";
							else if ($message==2) 
								echo "<h5 class=\"text-success\">Une filière a été supprimée</h5>";
							else if ($message== 1)
								echo "<h5 class=\"text-danger\">Modification Echec</h5>";
							else if ($message == 3)
								echo "<h5 class=\"text-danger\"> Echec de la Suppression</h5>";
							else if ($message == 4)
								echo "<h5 class=\"text-warning\">Impossible car des stagiaires appartiennent à cette filière </h5>";
							
						}
					?>
			</div>
		</div>
		<script>
			function changeURL (val,nomf,niv) {
				location.href = "filieres.php?page="+val+"&nomFil="+nomf+"&nivs="+niv;
			}
			/*var sel = document.getElementById ('sel');
			sel.addEventListener ('change',function () {
				location.href = "http://localhost/learning/projets/Gestion_Stagiaire/pages/filieres.php?page="+this.value;
			},false);*/
		</script>
	</body>
</html>

