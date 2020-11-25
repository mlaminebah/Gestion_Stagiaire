<?php
    session_start ();
    session_destroy ();
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
            <div class="cotainer-sm|md|lg|xl bg-secondary border" style="margin-top:12%;width:35%;margin-left:30%">
                <div class="container border bg-info text-white">
			        <h3 style="margin-top:10px;margin-left:5%">Connexion</h3>
		        </div>
                <div class="container text-white" style="margin-top:5%;margin-bottom:5%">
                    
                    <h4><a style = "margin-left:90%" class ="text-white" style ="margin-right:auto" href="pages/nouveauCompte.php"><i class="fas fa-user-plus"></i></a></h4>
                    <form action="seCon.php" name="search" id="search" onsubmit="return verif()" method="POST">
                        <div class="form-group">
                             <label for="login" class="font-weight-bold">login:</label>
			                 <input type="text" class="form-control" id ="login" name="login" placeholder="Votre login ou email"/>
                        </div>
                        <div class="form-group">
                             <label for="login" class="font-weight-bold">Mot de passe:</label>
			                 <input type="password" class="form-control" id ="mpw" name="mpw" placeholder="Votre mot de pass"/>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Je me connecte</button><br>
                        
                    </form><br>
                        
                            <a  class ="text-white" href="pages/mpOublier.php">Mot de pass Oublié ?</a>
                            
                        
                        <?php
                            if (isset($_GET['errMessage'])) {
                                echo "<div class=\"alert alert-warning\">";
                                $message = $_GET['errMessage'];
                                if ($message == 0) 
                                    echo "Login ou mot de pass incorrect";
                                else if ($message == 1) {
                                    echo "Ce compte a été désactiver veuillez contacter un administrateur";
                                    echo "</div>"; 
                                }
                                else if ($message == 2) {
                                    echo "<div class=\"alert alert-success\">";
                                        echo "Félicitation mot de pass modifier avec succès Veuillez vous connecter pour vérifier";
                                    echo "</div>";
                                }                                  
                            }
                        ?>
		        </div>
            </div>
            <script>
                function verif () {
                    if (document.getElementById('login').value == "" || document.getElementById('mpw').value == "") {
                        alert ("Vous devez fournir votre login et le mot de pass");
                        return false;
                    }
                    return true;
                }
                
            </script>
	</body>
</html>

