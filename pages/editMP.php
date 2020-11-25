<?php
    session_start ();
    try {
        require_once("connBD.php");
        if (!isset($_SESSION['user'])) header ("location:../index.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oldMP = isset($_POST['mpw'])?htmlentities(addslashes($_POST['mpw'])):"";
            $nwMDP = isset($_POST['nmpw'])?htmlentities(addslashes($_POST['nmpw'])):"";
            if (!empty($oldMP) && (strlen($oldMP) < 3 || strlen ($oldMP) > 6))
                $errMessage = "<strong>Erreur Ancien MP </strong> il faut 3 à 6 caractères";//l'ancien mot de passe doit être compris
            else if (!empty($nwMDP) && (strlen($nwMDP) < 3 || strlen ($nwMDP) > 6))
                $errMessage = "<strong>Erreur Nouveau MP </strong> il faut 3 à 6 caractères";
            else if (!empty($oldMP) && !empty($nwMDP) && MD5($oldMP) == MD5($nwMDP)) 
                $errMessage = "<strong>Erreur </strong> Le nouveau mot de pass doit être différent de l'ancien";
            else {
                $oldMP = MD5 ($oldMP);
                $nwMDP = MD5 ($nwMDP);
                $login = $_SESSION ['user']['login'];
                
                //on vérifie d'abord est que l'ancien mot de passe fourni est juste
                $reqVerif = "SELECT login,email,etat,role FROM Utilisateur WHERE (login = '$login' OR email = '$login') AND pwd = '$oldMP'";
                if ($base->query ($reqVerif)->rowCount () != 0) {
                    $req2 = "UPDATE Utilisateur SET pwd = '$nwMDP' WHERE login = '$login' OR email ='$login'";
                    if ($base->query($req2)) {
                        header ("location:../index.php?errMessage=2");
                    } else {
                        $errMessage = "<strong>Erreur</strong> Modification du mot de passe non réussie";
                    }
                } else $errMessage ="<strong>Erreur </strong> Ancien Mot de pass Incorrect";
            }
        }
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
            <div class="cotainer-sm|md|lg|xl bg-secondary border" style="margin-top:12%;width:30%;margin-left:30%">
                <div class="container border bg-info text-white">
			        <h3 style="margin-top:10px;margin-left:15%">Modification du Mot de pass</h3>
		        </div>
                <div class="container text-white" style="margin-top:5%;margin-bottom:5%">
                        <div class="form-group">
                             <h3><i class="fas fa-user"></i>&nbsp;<?php echo $_SESSION['user']['login'];?></h3>
                        </div>
                    <form action="editMP.php" name="search" id="search" method="POST">
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control" style="width:75%" id ="mpw" name="mpw" placeholder="Votre Ancien Mot de Pass" required/>
                             &nbsp;&nbsp;<i class="fas fa-eye-slash" id="slash1"></i>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control"  style="width:75%" id ="nmpw" name="nmpw" placeholder="Votre Nouveau Mot de pass" required/>
                             &nbsp;&nbsp;<i class="fas fa-eye-slash " id="slash2"></i>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-down"></i> Sauvegarder</button>
                    </form><br><br>
                    <?php
                            if (isset($errMessage)) {
                                echo "<div class=\"alert alert-warning\">";
                                    echo $errMessage;
                                echo "</div>";    
                            }
                    ?>
		        </div>
            </div>
            <script>
                var show1 = document.getElementById ('slash1'),show2 = document.getElementById ('slash2');
                show1.addEventListener ('click',function () {
                    var ipt = document.getElementById ('slash1'),name = ipt.className;
                        if (name == "fas fa-eye-slash") {
                            ipt.className = "fas fa-eye";
                            document.getElementById ('mpw').type="text";
                        }
                        else {
                            ipt.className = "fas fa-eye-slash";
                            document.getElementById ('mpw').type="password";
                        }
                });
                show2.addEventListener ('click',function () {
                    var ipt = document.getElementById ('slash2'),name = ipt.className;
                        if (name == "fas fa-eye-slash") {
                            ipt.className = "fas fa-eye";
                            document.getElementById ('nmpw').type="text";
                        }
                        else {
                            ipt.className = "fas fa-eye-slash";
                            document.getElementById ('nmpw').type="password";
                        }
                });
            </script>
	</body>
</html>

