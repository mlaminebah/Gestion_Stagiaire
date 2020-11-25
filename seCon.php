<?php
    session_start ();
    try {
        require_once("pages/connBD.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = isset ($_POST['login']) ? htmlentities(addslashes($_POST['login'])):"";
            $mp = isset ($_POST['mpw']) ? htmlentities(addslashes($_POST['mpw'])):"";
            if (!empty($mp) && !empty($login)) {
                $req = "SELECT login,email,etat,role FROM Utilisateur WHERE (login = '$login' OR email = '$login') AND pwd = MD5('$mp')";
                $res = $base -> query ($req);
                if ($res -> rowCount () != 0) {
                    $user = $res -> fetch ();
                    if ($user['etat'] == 1) {
                        $_SESSION ['user'] = $user;
                        header ("location:pages/filieres.php");
                    }
                    else {
                        $errMessage = 1;
                        session_destroy ();
                        header ("location:index.php?errMessage=".$errMessage);
                    }
                } else {
                    session_destroy ();
                    $errMessage = 0;
                    header ("location:index.php?errMessage=".$errMessage);
                }
            }
        }
    } catch (EXCEPTION $e) {
		die ('Erreur : '.$e->getMessage ());
	} finally {
		$base = null;
	}

?>