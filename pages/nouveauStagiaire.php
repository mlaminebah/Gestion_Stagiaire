<?php
    session_start ();
    if (!isset($_SESSION['user'])) header ("location:../index.php");
    
    require_once("connBD.php"); 
    $req = "SELECT * FROM Filiere";
    $res = $base -> query ($req);

    $nomP = isset ($_POST['nom']) ? htmlentities(addslashes($_POST['nom'])):"";
    $prenomP = isset ($_POST['prenom']) ? htmlentities(addslashes($_POST['prenom'])):"";
    $civP = isset ($_POST['optradio']) ? htmlentities(addslashes($_POST['optradio'])):"";
    $nomFP = isset ($_POST['nomFil']) ? htmlentities(addslashes($_POST['nomFil'])):"";
    $photoP = isset ($_FILES['photo']['name']) ? htmlentities(addslashes($_FILES['photo']['name'])):"";
    
    if (!empty ($nomFP) && !empty($prenomP) && !empty($civP) && !empty($nomP) && !empty ($photoP)) {
        $etat = move_uploaded_file ($_FILES ["photo"]["tmp_name"],"../images/".$_FILES["photo"]["name"]);
        
        ini_set('display_errors', TRUE); error_reporting(-1);
        if ($etat) {
            //chmod ("../images/".$_FILES["nomfichier"]["name"],0600);
            $requete = "INSERT INTO Stagiaire (nom,prenom,civilite,photo,IdFiliere) VALUES 
            ('$nomP','$prenomP','$civP','$photoP','$nomFP')";
            if ($base->query ($requete)) {
                $errMessage = 3;
                header ("location:stagiaires.php?errMessage=".$errMessage);
            } else {
                $errMessage = 4;
                header ("location:stagiaires.php?errMessage=".$errMessage);
            }
            
        } else 
           $message = "L'image n'a pas pu être chargée";
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
            <form action="nouveauStagiaire.php" name="search" id="search" onsubmit="return verif ()" method="POST" enctype="multipart/form-data" >    
                <div class="form-group">
					<label for="nom" class="font-weight-bold"> Nom:</label>
					<input type="text" class="form-control"  id="nom" name="nom" placeholder="Entrez votre Nom">
				</div>
                <div class="form-group">
					<label for="prenom" class="font-weight-bold">Nouveau Prénom:</label>
					<input type="text" class="form-control"  id="prenom" name="prenom" placeholder="Entrez votre Prénom"/>
				</div>
                <label for="nom" class="font-weight-bold">Sexe:</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" id ="optradio" name="optradio" value = "M" checked>M
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" id ="optradio" name="optradio" value="F">F
                    </label>
                </div>
                <div class="form-group">
					<label for="niveau" class="font-weight-bold">Nouvelle Filière:</label>
					<select class="form-control form-control-sm" name="nomFil" id="nomFil">
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
                    <?php 
                        if (isset ($message)) {
                            echo "<h5 class=\"text-danger\">$message</h5>";
                        }
                    ?>
				</div>
                <button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-down"></i> Enregistrer</button>
            </form>
        </div>
        <script>
            function verif () {
                var image = document.getElementById('photo').files[0],
                option = document.getElementById ('optradio').value,
                list = document.getElementById ('nomFil'),nomFil = list.options [list.selectedIndex].value;
                
                if (document.search.nom.value =="" || document.search.prenom.value =="" || typeof(image) == 'undefined' || nomFil == "") {
                    alert ("Aucun champs ne doit être vide");
                    return false;
                }
                var imgType = ["image/jpeg","image/JPEG","image/PNG","image/png","image/jpg","image/JPG","image/gif","image/GIF"];
                if (imgType.indexOf(image.type) == -1) {
                    alert ("Vous devez entrez une image de type : "+imgType);
                    return false;
                }
                if (document.search.nom.value.length < 2 || document.search.prenom.value.length < 2) {
                    alert ("La longueur du nom ou de prénom doit être > 2 caractères");
                    return false;
                }
                return true;
            }
        </script>
	</body>
</html>
