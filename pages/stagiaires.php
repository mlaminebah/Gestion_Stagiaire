<?php 
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
	try { 
		require_once("connBD.php");
		
		$limite = isset($_GET['limite'])?$_GET['limite']:3;
		$page = isset($_GET['page']) ? $_GET['page']:1;
		$start = ($page-1) * $limite;
		
		$req = "SELECT * FROM Filiere";
		$res = $base->query ($req);
		
		$nomPrenom = isset ($_GET['nomPrenom'])?strtoupper(htmlentities(addslashes($_GET['nomPrenom']))):"";
		$selF = isset ($_GET['selF'])?htmlentities(addslashes($_GET['selF'])):"all";
		
		if (!empty ($selF) && ($selF == "all" || $selF == 0)) {
			$req2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
						FROM Stagiaire S ,Filiere F WHERE S.IdFiliere = F.IdFiliere ORDER BY IdStagiaire LIMIT $start,$limite"
			);
			//$res2 = $base->query ($req2);
			$req2_2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
						FROM Stagiaire S ,Filiere F WHERE S.IdFiliere = F.IdFiliere ORDER BY IdStagiaire"
			);
			//$nbr = $base->query($req2_2)->rowCount();
		} else if (empty($selF)) {
			$req2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
					FROM Stagiaire S INNER JOIN Filiere F ON (S.IdFiliere = F.IdFiliere) 
					WHERE nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%' ORDER BY IdStagiaire
					LIMIT $start,$limite"
			);
		
			//$res2 = $base->query ($req2);
			$req2_2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
						FROM Stagiaire S INNER JOIN Filiere F ON (S.IdFiliere = F.IdFiliere) 
						WHERE nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%' ORDER BY IdStagiaire"
			);
			//$nbr = $base->query($req2_2)->rowCount();
		} else if (empty ($nomPrenom)) {
			$req2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
					FROM Stagiaire S,Filiere F WHERE (S.IdFiliere = F.IdFiliere) 
					AND F.IdFiliere = $selF ORDER BY IdStagiaire LIMIT $start,$limite"
			);
			$req2_2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
					FROM Stagiaire S,Filiere F WHERE (S.IdFiliere = F.IdFiliere) 
					AND F.IdFiliere = $selF ORDER BY IdStagiaire"			
			);
		}else {
			$req2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
					FROM Stagiaire S INNER JOIN Filiere F ON (S.IdFiliere = F.IdFiliere) 
					WHERE F.IdFiliere = $selF AND (nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%') ORDER BY IdStagiaire
					LIMIT $start,$limite"
			);
			$req2_2 = ("SELECT IdStagiaire,nom,prenom,civilite,nomFiliere,photo 
				FROM Stagiaire S INNER JOIN Filiere F ON (S.IdFiliere = F.IdFiliere) 
				WHERE F.IdFiliere = $selF AND (nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%') ORDER BY IdStagiaire"
			);
		}		
		$res2 = $base->query ($req2);
		$nbr = $base->query($req2_2)->rowCount();
		
		$reste = $nbr%$limite;
		$nbrPage = $reste == 0 ? ($nbr/$limite):floor($nbr/$limite) + 1;
	} catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	} finally {
		$base = null;
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
		<?php
			include ('menu.php');
		?>
		<div class="container border" style="margin-top:30px;padding-bottom:15px">
			<div class="row bg-success text-white">
				<h6 style="margin-top:10px;margin-left:20px">Recherche des Stagiaires</h6>
			</div>
			<div class="row" style="margin-top:30px;margin-left:20px">
				
				<div class="col-8">
				   <form class="form-inline" method="GET" name="search" onsubmit="return verif()">
				  	   <input type="text" class="form-control form-control-sm" placeholder="Nom ou Prénom" name="nomPrenom" id="nomPrenom">
					   <label for="niveau" class="font-weight-bold"> Filière:</label>
					   <select id ="selF" class="form-control form-control-sm" name="selF"> 
					   	   <option value=""></option>
						   <option value="all">Toutes les Filières</option>
						<?php
							while ($donnees=$res->fetch ()) {
								$id = $donnees ['IdFiliere'];
								echo "<option value=$id>".$donnees['nomFiliere']."</option>";
							}
						?>
						</select>
					   <button type="submit" name="rsearch" id="rsearch" class="btn btn-success">
							<i class="fas fa-search"></i>Rechercher
					   </button>
				   </form>
				</div>
				<?php if ($_SESSION['user']['role'] == "Admin") {?>
					<div class="col-4">
						<a href="nouveauStagiaire.php" class="nav-link"><i class="fas fa-plus"></i> Ajout Stagiaire</a>
					</div>
				<?php }?>
				
			</div>
		</div>
		
		<div class="container border bg-info text-white" style="margin-top:40px">
			<h6 style="margin-top:10px;margin-left:20px">Liste des Stagiaires(<?php echo $nbr;?>stagiaire(s))</h6>
		</div>
		
		<div class="container border" style="padding-bottom:40px">
			<table class="table table-striped table-hover">
				
				<thead class="bg-muted">
					<tr>
						<th><?php echo strtoupper("id") ;?></th>
						<th><?php echo strtoupper("Nom") ;?></th>
						<th><?php echo strtoupper("Prenom") ;?></th>
						<th><?php echo strtoupper("Sexe") ;?></th>
						<th><?php echo strtoupper("Filieres") ;?></th>
						<th><?php echo strtoupper("Photo") ;?></th>
						
						<?php if ($_SESSION['user']['role'] == "Admin") {?>
							<th><?php echo strtoupper("Actions") ;?></th>
						<?php }?>
					</tr>
				</thead>
				
				<tbody>
					<?php
						while ($donnees2 = $res2 -> fetch ()) {
							$id  = $donnees2['IdStagiaire'];
							$nom = $donnees2['nom'];
							$prenom = $donnees2['prenom'];
							$civ = $donnees2['civilite'];
							$nomF = $donnees2['nomFiliere'];
							$photo = $donnees2['photo'];
							?>
							<tr>
								<td><?php echo $id;?></td>
								<td><?php echo $nom;?></td>
								<td><?php echo $prenom;?></td>
								<td><?php echo $civ;?></td>
								<td><?php echo $nomF;?></td>
								<td><img src="../images/<?php echo $photo;?>" class="rounded" width="60" height="65"
								alt="<?php echo $photo;?>"></td>
								<?php if ($_SESSION['user']['role'] == "Admin") {?>
									<td><a href="editStagiaire.php?id=<?php echo $id;?>&nom=<?php echo $nom;?>
										&prenom=<?php echo $prenom;?>&civ=<?php echo $civ;?>&nomF=<?php echo $nomF;?>&photo=<?php echo $photo;?>" onclick="
											return confirm('Attention voulez vous vraiment le modifier')"><i class="fas fa-wrench"></i>
										</a>
										<a href="supStagiaire.php?id=<?php echo $id;?>" onclick="
											return confirm('Attention voulez vous vraiment le supprimer?')"><i class="fas fa-cut" style="margin-left:20px"></i>
										</a>
									</td>
								<?php }?>
							</tr>
					<?php } ?>
				</tbody>
				
			</table>
			
			<div class="container-fluid">
					<ul class="pagination">
						<li class="page-item">
						<?php		
							$np = isset ($_GET['nomPrenom'])?strtoupper(htmlentities(addslashes($_GET['nomPrenom']))):"";
							$sf = isset ($_GET['selF'])?htmlentities(addslashes($_GET['selF'])):"";
							echo "<select id =\"sel\" class=\"form-control form-control-sm\" Placeholder=\"N°Page\" 
							onchange=\"changeURL(this.value,'$np','$sf')\">";?>
						?>
									<option value=""><?php echo "Page N° ".$page."/".$nbrPage; ?></option>
								<?php
									for ($i = 1; $i <= $nbrPage ; $i ++)
									 echo "<option value=\"$i\">$i</option>";
								?>
								</select>
						</li>
						<li class="page-item <?php if($page == 1) echo "disabled";?>"> 
							<a class="page-link" href="stagiaires.php?page=
							<?php if (($page - 1) > 0) echo $page - 1;else echo 1;?>&nomPrenom=
							<?php echo $nomPrenom;?>&selF=<?php echo $selF;?>">Previous</a>
						</li>
						<?php
							for ($i=1 ; $i <= ($nbrPage/2);$i ++) {?>
								<li class="page-item <?php if ($page == $i) echo "active";?>">
									<a class="page-link" href="stagiaires.php?page=
									<?php echo $i; ?>&nomPrenom=<?php echo $nomPrenom;?>&selF=<?php echo $selF;?>"><?php echo $i;?></a>
								</li>
						<?php
							}?>
						</li>
						<li class="page-item <?php if ($page > ($nbrPage/2) && $page + 1 <= $nbrPage) echo "active";else if ($page ==  $nbrPage) echo "disabled";?>">
							<a class="page-link" href="stagiaires.php?page=
							<?php if (($page + 1) <= $nbrPage) echo ($page + 1); else $page;?>&nomPrenom=
							<?php echo $nomPrenom;?>&selF=<?php echo $selF;?>">Next</a>
						</li>
					</ul>	
					<?php
						if (isset($_GET['errMessage'])) {
							$message = $_GET['errMessage'];
							if ($message == 0) 
								echo "<h5 class=\"text-success\">Un stagiaire a été supprimé</h5>";
							else if ($message == 1)
								echo "<h5 class=\"text-danger\">Echec suppression</h5>";
							else if ($message == 2)
								echo "<h5 class=\"text-success\">Un stagiaire a été modifié </h5>";
							else if ($message == 3) 
								echo "<h5 class=\"text-success\">Un stagiaire a été Ajouté </h5>";
							else if ($message == 4)
								echo "<h5 class=\"text-success\">Echec Ajout du stagiaire</h5>";
							else 
								echo "<h5 class=\"text-danger\">Echec suppression</h5>";
						}
					?>		
			</div>
		</div>
		
		<script>
			function changeURL (val,np,self) {
				location.href = "stagiaires.php?page="+val+"&nomPrenom="+np+"&selF="+self;
			}
			function verif () {
				var list = document.getElementById ('selF');
				var val = list.options [list.selectedIndex].value;
				if (val == "" && document.search.nomPrenom.value == "") {
					alert ("Tous les champs ne doivent pas être vides");
					return false;
				}

				return true;
			}
		</script>
	</body>
</html>

