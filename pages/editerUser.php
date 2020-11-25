<?php
    session_start ();
	if (!isset($_SESSION['user'])) header ("location:../index.php");
    require_once("connBD.php");
    $log = isset ($_GET['log']) ? htmlentities(addslashes($_GET['log'])):"";
    $email = isset ($_GET['email']) ? htmlentities(addslashes($_GET['email'])):"";
    $role = isset ($_GET['role']) ? htmlentities(addslashes($_GET['role'])):"";
    $etat = isset ($_GET['etat']) ? htmlentities(addslashes($_GET['etat'])):"";
    
    $logF = isset ($_POST['login']) ? htmlentities(addslashes($_POST['login'])):"";
    $emailF = isset ($_POST['email']) ? htmlentities(addslashes($_POST['email'])):"";
    $roleF = isset ($_POST['role']) ? htmlentities(addslashes($_POST['role'])):"";
    $etatF = isset ($_POST['optradio']) ? htmlentities(addslashes($_POST['optradio'])):"";
    if (!empty($logF) && !empty($emailF) ) {
        
        $req = "SELECT *FROM Utilisateur WHERE email = '$emailF' AND login <> '$logF'";
        $res = $base -> query ($req);
        if ($res->rowCount () != 0) {
           
            $errMessage = 2;
        } else {
            if ($_SESSION['user']['role'] == "Admin") {
                $req2 = "UPDATE Utilisateur SET email = '$emailF',role = '$roleF',etat = '$etatF' WHERE login = '$logF'";
                if ($base -> query ($req2))  $errMessage = 3;
                else $errMessage = 4;
                
            } else {
                $req2 = "UPDATE Utilisateur SET email = '$emailF' WHERE login = '$logF'";
                if ($base -> query ($req2))  $errMessage = 3;
                else $errMessage = 4;
            }
                
        }
        header ("location:utilisateurs.php?errMessage=".$errMessage);
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
			<h6 style="margin-top:10px;margin-left:20px">Editer <?php echo $_SESSION['user']['login'] == $log ? "mon compte":"un Utilisateur"; ?></h6>
		</div>
        <div class="container border" style="padding-bottom:40px">
            <form action="editerUser.php" name="search" id="search" onsubmit="return verif ()" method="POST">
                <div class="form-group">
                    <label for="login" class="font-weight-bold">User :<?php echo " ".$log;?></label>
			        <input type="hidden" class="form-control" value="<?php echo $log;?>" readonly="true" name="login" id ="login"/>
                </div>    
                <div class="form-group">
					<label for="email" class="font-weight-bold">Nouveau Email:</label>
					<input type="email" class="form-control"  id="email" name="email" value="<?php echo $email;?>">
				</div>
                <?php if ($_SESSION['user']['role'] == "Admin") {?>
                    <div class="form-group">
                        <label for="role" class="font-weight-bold">Nouveau Rôle:</label>
                        <select class="form-control form-control-sm" name="role" id="role">
                                <option value="<?php echo $role;?>"><?php echo $role;?></option>
                                <option value="<?php echo $role == "Admin" ? "Visiteur":"Admin";?>"><?php echo $role == "Admin" ? "Visiteur":"Admin";?></option>
                        </select>
                    </div>
                    <label for="etat" class="font-weight-bold">Etat</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id ="optradio" name="optradio" value = "0" <?php if ($etat == 0) echo "checked";?>>Désactiver
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" id ="optradio" name="optradio" value= "1" <?php if ($etat == 1) echo "checked";?>>Activer
                        </label>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-down"></i> Enregistrer</button> &nbsp;&nbsp;
                <a href="editMP.php">Modifier le mot de passe</a>
            </form>
        </div>
        <script>
            function verif () {
                var list = document.getElementById ('role'),role = list.options [list.selectedIndex].value;
                if (document.search.login.value =="" || document.search.email.value =="" ||  role == "") {
                    alert ("Aucun champs ne doit être vide");
                    return false;
                }
                return true;
            }
        </script>
	</body>
</html>
