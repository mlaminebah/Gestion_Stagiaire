<?php
    session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    require_once("connBD.php");
    $id = isset ($_GET['id']) ? htmlentities(addslashes($_GET['id'])):"";
    $nom = isset ($_GET['nom']) ? htmlentities(addslashes($_GET['nom'])):"";
    $prenom = isset ($_GET['prenom']) ? htmlentities(addslashes($_GET['prenom'])):"";
    $civ = isset ($_GET['civ']) ? htmlentities(addslashes($_GET['civ'])):"";
    $nomF = isset ($_GET['nomF']) ? htmlentities(addslashes($_GET['nomF'])):"";
    $photo = isset ($_GET['photo']) ? htmlentities(addslashes($_GET['photo'])):"";
    $req = "SELECT * FROM Filiere";
    $req2 = "SELECT *FROM Filiere WHERE nomFiliere = '$nomF'";
    $res2 = $base->query($req2);
    $res2 = $res2 -> fetch ();
    $idFil = $res2 ['IdFiliere'];
  ////  $idFil = $res2 -> rowCount ();
    $res = $base->query ($req);
    $nomP = isset ($_POST['nom']) ? htmlentities(addslashes($_POST['nom'])):"";
    $prenomP = isset ($_POST['prenom']) ? htmlentities(addslashes($_POST['prenom'])):"";
    $idP = isset ($_POST['id']) ? htmlentities(addslashes($_POST['id'])):"";
    $civP = isset ($_POST['optradio']) ? htmlentities(addslashes($_POST['optradio'])):"";
    $nomFP = isset ($_POST['nomFil']) ? htmlentities(addslashes($_POST['nomFil'])):"";
    $photoP = isset ($_FILES['photo']['name']) ? htmlentities(addslashes($_FILES['photo']['name'])):"";
    if (!empty ($nomP)&& !empty($prenomP)&& !empty ($idP) && !empty ($civP)) {
        if (empty ($photoP)) {
            
            $req = "UPDATE Stagiaire SET nom = '$nomP',prenom = '$prenomP',civilite = '$civP' 
                ,IdFiliere = '$nomFP' WHERE IdStagiaire = '$idP'";
            if ($base -> query ($req)) $errMessage = 2;
            else $errMessage = 3;
           header ("location:stagiaires.php?errMessage=".$errMessage);
        } else {
            $tab = array ('image/jpeg','image/JPEG','image/PNG','image/png','image/jpg','image/JPG','image/gif','image/GIF');
            $type = $_FILES ["photo"]["type"];
            if (in_array($type,$tab)) {  

                $etat = move_uploaded_file ($_FILES ["photo"]["tmp_name"],"../images/".$_FILES["photo"]["name"]);
                
                ini_set('display_errors', TRUE); error_reporting(-1);
                if ($etat) {
                   // chmod ("../images/".$_FILES["nomfichier"]["name"],0600);
                    $req = "UPDATE Stagiaire SET nom = '$nomP',prenom = '$prenomP',civilite = '$civP',photo= '$photoP'
                            ,IdFiliere = '$nomFP' WHERE IdStagiaire = '$idP'";
                    if ($base -> query ($req)) $errMessage = 2;
                    else $errMessage = 3;
                    header ("location:stagiaires.php?errMessage=".$errMessage);
                } else 
                    $message = "le fichier n'a pas pu être chargé";
            } else $message = "Format invalide vous devez fournir une image";
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
			<h6 style="margin-top:10px;margin-left:20px">Editer un stagiaire</h6>
		</div>
        <div class="container border" style="padding-bottom:40px">
            <form action="editStagiaire.php" name="search" id="search" onsubmit="return verif ()" method="POST" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="id" class="font-weight-bold">Stagiaire N°:<?php echo " ".$id;?></label>
			        <input type="hidden" class="form-control" value="<?php echo $id;?>" readonly="true" name="id"/>
                </div>    
                <div class="form-group">
					<label for="nom" class="font-weight-bold">Nouveau Nom:</label>
					<input type="text" class="form-control"  id="nom" name="nom" value="<?php echo $nom;?>">
				</div>
                <div class="form-group">
					<label for="prenom" class="font-weight-bold">Nouveau Prénom:</label>
					<input type="text" class="form-control"  id="prenom" name="prenom" value="<?php echo $prenom;?>">
				</div>
                <label for="nom" class="font-weight-bold">Sexe:</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" id ="optradio" name="optradio" value = "M" <?php if ($civ == 'M') echo "checked";?>>M
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" id ="optradio" name="optradio" value="F" <?php if ($civ == 'F') echo "checked";?>>F
                    </label>
                </div>
                <div class="form-group">
					<label for="niveau" class="font-weight-bold">Nouvelle Filière:</label>
					<select class="form-control form-control-sm" name="nomFil" id="nomFil" Placeholder="Tous les niveaux">
							<option value="<?php echo $idFil;?>"><?php echo $nomF;?></option>
                            <option value=""></option>
							<?php
                                while ($val = $res->fetch()) {?>
                                    <option value="<?php echo $val['IdFiliere']; ?>"><?php echo $val['nomFiliere'];?></option>
                                <?php } 
                            ?>
					</select>
				</div>
                <div class="form-group">
					<label for="niveau" class="font-weight-bold">Photo:</label>
					<input type="file" class="form-control-file border" name="photo" id="photo">
				</div>
                <button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-down"></i> Enregistrer</button>
            </form>
            <?php 
                if (isset ($message)) {
                    echo "<h5 class=\"text-danger\">$message</h5>";
                }
            ?>
        </div>
        <script>
            function verif () {
                var position = window.location.href.indexOf('=');
				var don = window.location.href.substr(position + 1);
				     don = don.split ("&");
              //  var id = don [0];
                var nom = don[1].split ("="), nom = nom[1],
                    prenom = don[2].split ("="),prenom = prenom[1],
                    civ = don[3].split ("="),civ = civ[1],
                    nomF = don[4].split ("="), nomF = nomF[1],
                    photoF = don[5].split ("="),photoF = photoF [1],
                    list = document.getElementById ('nomFil'),nomFil = list.options [list.selectedIndex].value,
                    option = document.getElementById ('optradio').value;
                if (document.search.nom.value =="" || document.search.prenom.value =="" || nomFil == "") {
                    alert ("Aucun champs ne doit être vide");
                    return false;
                }
                //console.log (document.search.photo.value);
                //if (document.search.photo.value != "" photoF != document.search.photo.value) return true;
                if (nom == document.search.nom.value && prenom == document.search.prenom.value && 
                    nomF == nomFil && option == civ) {
                    alert ("Un des champs au moins doit être modifié");
					return false;
                }

                return true;
            }
        </script>
	</body>
</html>
