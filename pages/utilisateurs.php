<?php
	session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    try { 
        require_once("connBD.php");
        $limite = isset($_GET['limite'])?$_GET['limite']:6;
		$page = isset($_GET['page']) ? $_GET['page']:1;
        $start = ($page-1) * $limite;

        $login = isset($_GET['login'])?htmlentities(addslashes($_GET['login'])):"";
        $req2 = "SELECT *FROM Utilisateur ORDER BY etat DESC LIMIT $start,$limite";
        $req = "SELECT *FROM Utilisateur";
        if (!empty ($login)) {
            
            $req2 = "SELECT *FROM Utilisateur WHERE login LIKE '%$login%' ORDER BY etat DESC LIMIT $start,$limite";
            $req = "SELECT *FROM Utilisateur WHERE login LIKE '%$login%'";
        }         
        $res = $base -> query ($req);
        $resultat = $base -> query ($req2);
        $nbr = $res -> rowCount ();

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
				<h6 style="margin-top:10px;margin-left:20px">Recherche des Utilisateurs</h6>
			</div>
            <div class="row" style="margin-top:30px;margin-left:20px">
				
				<div class="col-8">
				   <form class="form-inline" method="GET" name="search" onsubmit="return verif()" action="utilisateurs.php">
				  	   <input type="text" class="form-control form-control-sm" placeholder="login" name="login" id="login">
					   <button type="submit" class="btn btn-success">
							<i class="fas fa-search"></i> Rechercher
					   </button>
				   </form>
				</div>
			</div>
        </div>

        <div class="container border bg-info text-white" style="margin-top:40px">
			    <h6 style="margin-top:10px;margin-left:20px">Liste des Utilisateurs(<?php echo " $nbr ";?>utilisateur(s))</h6>
		</div>

        <div class="container border" style="padding-bottom:40px">
			<table class="table table-striped table-hover">
				
				<thead class="bg-muted">
					<tr>
						<th><?php echo strtoupper("login") ;?></th>
						<th><?php echo strtoupper("email") ;?></th>
						<th><?php echo strtoupper("role") ;?></th>
						<th><?php echo strtoupper("etat") ;?></th>
                        <th><?php echo strtoupper("Actions") ;?></th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        while ($don = $resultat -> fetch ()) {
                            $login = $don ['login'];
                            $email = $don ['email'];
                            $role = $don ['role'];
                            $etat = $don ['etat'];
                            ?>
                            <tr class="<?php echo $etat == 1? 'bg-muted':'bg-danger text-white';?>">
                                <td><?php echo $login;?></td>
                                <td><?php echo $email;?></td>
                                <td><?php echo $role;?></td>
                                <td>
								<?php if ($_SESSION['user']['role'] == "Admin") {?>
									<a href="ActDeactive.php?log=<?php echo $login;?>&etat=<?php echo $etat;?>">
                                   	 	<?php 
                                        	if ($etat == 0) echo "<i class=\"fas fa-user-slash\"></i>";
                                       		 else if ($etat == 1) echo "<i class=\"fas fa-user\"></i>";
                                    	?>
									</a>
								<?php } else if ($_SESSION['user']['role'] == "Visiteur") {
										if ($_SESSION['user']['login'] == $login) {?>
												<a href="ActDeactive.php?log=<?php echo $login;?>&etat=<?php echo $etat;?>">
													<?php 
														if ($etat == 0) echo "<i class=\"fas fa-user-slash\"></i>";
														else if ($etat == 1) echo "<i class=\"fas fa-user\"></i>";
													?>
												</a>
										<?php } else {?>
												<a href="">
													<?php 
														if ($etat == 0) echo "<i class=\"fas fa-user-slash\"></i>";
														else if ($etat == 1) echo "<i class=\"fas fa-user\"></i>";
													?>
												</a>
										<?php }
									}
								?>
                                </td>
								<?php if ($_SESSION['user']['role'] == "Admin") {?>
									<td><a href="editerUser.php?log=<?php echo $login;?>&email=<?php echo $email;?>&role=<?php echo $role;?>&etat=<?php
										echo $etat;?>" onclick=
										"return confirm('Attention voulez vous vraiment le modifier?')"><i class="fas fa-wrench"></i>
										</a>
										<a href="supprimerUser.php?log=<?php echo $login;?>" onclick="
											return confirm('Attention voulez vous vraiment le Suprimer?')"><i class="fas fa-cut" style="margin-left:20px"></i>
										</a>
									</td>
								<?php } else if ($_SESSION['user']['role'] == "Visiteur" && $_SESSION['user']['login'] == $login) {?>
										<td><a href="editerUser.php?log=<?php echo $login;?>&email=<?php echo $email;?>&role=<?php echo $role;?>&etat=<?php
											echo $etat;?>" onclick=
											"return confirm('Attention voulez vous vraiment le modifier?')"><i class="fas fa-wrench"></i>
											</a>
											<a href="supprimerUser.php?log=<?php echo $login;?>" onclick="
												return confirm('Attention voulez vous vraiment le Suprimer?')"><i class="fas fa-cut" style="margin-left:20px"></i>
											</a>
										</td>
								<?php }		
								?>
                            <tr>
                        <?php }
                        ?>
                </tbody>
            </table>
            <div class="container-fluid">

					<ul class="pagination">
						
						<li class="page-item">
						<?php 	
								$log = isset($_GET['login'])?htmlentities(addslashes($_GET['login'])):"";
							echo "<select id =\"sel\" class=\"form-control form-control-sm\" Placeholder=\"N°Page\" onchange=\"changeURL(this.value,'$log')\">";?>
									<option value=""><?php echo "Page N° ".$page."/".$nbrPage; ?></option>
								<?php
									for ($i = 1; $i <= $nbrPage ; $i ++)
									 echo "<option value=\"$i\">$i</option>";
								?>
							</select>
						</li>
						<li class="page-item <?php echo $page == 1? "disabled":"active";?>"> 
							<a class="page-link" href="utilisateurs.php?page=
							<?php echo (($page - 1) > 0) ? $page - 1 : $page;?>&login=
							<?php echo isset($_GET['login'])?htmlentities(addslashes($_GET['login'])):"";?>">Previous</a>
						</li>
						<li class="page-item <?php echo $page < $nbrPage ? "active":"disabled"; ?>">
							<a class="page-link" href="utilisateurs.php?page=<?php echo ($page + 1) <= $nbrPage ? $page + 1 : $page;?>&login=
							<?php echo isset($_GET['login'])?htmlentities(addslashes($_GET['login'])):"";?>">Next</a>
						</li>					
					</ul>
                </div>
				<?php
						if (isset($_GET['errMessage'])) {
							$message = $_GET['errMessage'];
							if ($message == 0) 
							   echo "<h5 class=\"text-success\">Un utilisateur a été supprimée</h5>";
							else if ($message==1) 
								echo "<h5 class=\"text-danger\">Echec de suppression de l'utilisateur</h5>";
							else if ($message==2)
								echo "<h5 class=\"text-danger\">Echec de la modification (Cet émail est déjà utilisé par une autre personne)</h5>";
							else if ($message==3)
								echo "<h5 class=\"text-success\">Un utilisateur a été modifié</h5>";
							else 
								echo "<h5 class=\"text-danger\">Echec modification d'un utilisateur</h5>";
						}
					?>
        </div>
        <script>
            function verif () {
                if (document.getElementById ('login').value == ""){
                    alert ("Le champs login ne doit pas être vide");
                    return false;
                }
                return true;
            }
			function changeURL (val,log) {
				location.href = "utilisateurs.php?page="+val+"&login="+log;
			}
        </script>
	</body>
</html>