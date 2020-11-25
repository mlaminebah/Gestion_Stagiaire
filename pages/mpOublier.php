<?php
    function verifExiste_log ($log,$base) {
        $req = "SELECT login FROM Utilisateur WHERE login = '$log' OR email = '$log'";
        $res = $base -> query ($req);
        return $res->rowCount () != 0;
    }
    try {
            require_once("connBD.php");
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $mp = isset($_POST['mpw'])?htmlentities(addslashes($_POST['mpw'])):"";
                $cmp = isset($_POST['nmpw'])?htmlentities(addslashes($_POST['nmpw'])):"";
                if (strlen ($mp) < 3 || strlen($mp) > 6)
                    $errorMessage = "<p class=\"alert alert-warning\"><strong>Erreur Mot de pass </strong> doit être compris de 3 à 6 cartactères</p>";
                else if ((!empty($cmp) && !empty($mp)) && (MD5($cmp) != MD5($mp)))
                    $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur</strong> Les deux mots de pass doit être identiques</p>";
                else {
                    $log = isset($_POST['login'])?htmlentities(addslashes($_POST['login'])):"";
                    $log = filter_var ($log,FILTER_SANITIZE_STRING);
                    if (verifExiste_log($log,$base)) {
                        //on modifie donc le mot pass de l'utilisateur
                        $cmp = MD5 ($cmp);
                        $req = "UPDATE Utilisateur SET pwd = '$cmp' WHERE login = '$log' OR email ='$log'";
                        if ($base->query($req)) {
                            header ("location:../index.php?errMessage=2");
                        } else 
                             $errorMessage = "<p class=\"alert alert-danger\"> <strong>Erreur </strong> Echec modification du mot de pass</p>";
                    } else 
                        $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur</strong> Aucun compte n'existe pour ce login ou email</p>";
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
            <div class="cotainer-sm|md|lg|xl bg-secondary border" style="margin-top:10%;width:30%;margin-left:30%">
                <div class="container border bg-info text-white text-center">
			        <h4 style="margin-top:10px;">Mot De pass oublié</h4>
		        </div>
                <div class="container text-white" style="margin-top:5%;margin-bottom:1%">
                    <form action="mpOublier.php" name="search" id="search" method="POST">
                        <div class="form-group form-inline">
			                 <input type="text" class="form-control" style="width:75%" id ="login" 
                                name="login" placeholder="Entrer votre email ou votre login"
                                minlength="3" autocomplete="off" required/>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control" style="width:75%" id ="mpw" 
                                name="mpw" placeholder="Entrer votre Nouveau mot de pass"
                                minlength="3" maxlength="6" autocomplete="off" title="le mot de pass doit être compris entre 3 et 6 caractères" required/>
                             &nbsp;&nbsp;<i class="fas fa-eye-slash" id="slash1"></i>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control"  style="width:75%" id ="nmpw" name="nmpw" placeholder="Confirmer votre nouveau mot de pass" 
                             minlength="3" maxlength="6" autocomplete="new-password" title="le mot de pass doit être compris entre 3 et 6 caractères" required/>
                             &nbsp;&nbsp;<i class="fas fa-eye-slash " id="slash2"></i>
                        </div>
                        <button type="submit" class="btn btn-success" style="width:75%"><i class="fas fa-arrow-alt-circle-down"></i> Sauvegarder</button>
                    </form><br>
                    <?php
                        echo isset($errorMessage) ? $errorMessage : "";
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

