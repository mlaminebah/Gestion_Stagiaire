<?php
    
    try {
        function verifExiste_log ($log,$base) {
            $req = "SELECT login FROM Utilisateur WHERE login = '$log'";
            $res = $base -> query ($req);
            return $res->rowCount () != 0;
        }
        function verifExiste_email ($mail,$base) {
            $req = "SELECT login FROM Utilisateur WHERE email = '$mail'";
            $res = $base -> query ($req);
            return $res->rowCount () != 0;
        }
        require_once("connBD.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $log = isset($_POST['login'])?htmlentities(addslashes($_POST['login'])):"";
            $email = isset($_POST['mail'])?htmlentities(addslashes($_POST['mail'])):"";
            $mp = isset($_POST['mpw'])?htmlentities(addslashes($_POST['mpw'])):"";
            $cmp = isset($_POST['nmpw'])?htmlentities(addslashes($_POST['nmpw'])):"";
            if (strlen ($log) < 3)
                $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur Login </strong> trop court minimum requis 3 caractères</p>";
            else if (strlen ($email) < 3)
                $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur email </strong> trop court minimum requis 3 caractères</p>";
            else if (strlen ($mp) < 3 || strlen($mp) > 6)
                $errorMessage = "<p class=\"alert alert-warning\"><strong>Erreur Mot de pass </strong> doit être compris de 3 à 6 cartactères</p>";
            else if ((!empty($cmp) && !empty($mp)) && (MD5($cmp) != MD5($mp)))
                $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur</strong> Les deux mots de pass doit être identiques</p>";
            else {
                $log = filter_var ($log,FILTER_SANITIZE_STRING);
                $email = filter_var ($email,FILTER_SANITIZE_EMAIL);
                if ($email != true) $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur email </strong> Invalid</p>";
                else  {
                    if (verifExiste_log($log,$base)) 
                        $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur</strong> Login déjà utilisé</p>";
                    else if (verifExiste_email ($email,$base)) 
                        $errorMessage = "<p class=\"alert alert-warning\"> <strong>Erreur</strong> Email déjà utilisé</p>";
                    else {
                        $requete = "INSERT INTO Utilisateur (login, email, role, etat, pwd) VALUES ('$log','$email','Visiteur',0,MD5('$cmp'))";
                        $res = $base -> query ($requete);
                        if ($res) $errorMessage = "<p class=\"alert alert-success\"> <strong>Succès</strong> Votre comtpe a bien été créé vous allez être 
                            contacté pour une confirmation</p>";
                        else 
                            $errorMessage = "<p class=\"alert alert-danger\"> <strong>Erreur </strong> Votre compte n'a pas pu être créer/p>";
                    }
                }
                
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
			        <h4 style="margin-top:10px;">Création d'un nouveau compte</h4>
		        </div>
                <div class="container text-white" style="margin-top:5%;margin-bottom:1%">
                    <form action="nouveauCompte.php" name="search" id="search" method="POST">
                        <div class="form-group form-inline">
			                 <input type="text" class="form-control" style="width:75%" id ="login" 
                                name="login" placeholder="Entrer votre login"
                                minlength="3" autocomplete="off" title="le login doit avoir au moins 3 caractères" required/>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="email" class="form-control" style="width:75%" id ="mail" 
                                name="mail" placeholder="Entrer votre email"
                                minlength="3" autocomplete="off" title="Votre email doit avoir au moins trois caractères" required/>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control" style="width:75%" id ="mpw" 
                                name="mpw" placeholder="Entrer votre mot de pass"
                                minlength="3" maxlength="6" autocomplete="off" title="le mot de pass doit être compris entre 3 et 6 caractères" required/>
                             &nbsp;&nbsp;<i class="fas fa-eye-slash" id="slash1"></i>
                        </div>
                        <div class="form-group form-inline">
			                 <input type="password" class="form-control"  style="width:75%" id ="nmpw" name="nmpw" placeholder="Confirmation du mot de pass" 
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

