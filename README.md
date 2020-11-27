<h1>Gestion_Stagiaire</h1>


<ol>
  <li><h3>Objectif</h3>
      Ceci est une petite application de gestion d'un ensemble de stagiaie .
      Elle met en pratique les technologies/langages suivant(e)s :
      <ul>
        <li>PHP</li>
        <li>HTML</li>
        <li>CSS/BOOSTRAP</li>
        <li>Javascript</li>
      </ul>
  </li>
  <li><h3>Fonctionnalités</h3>
      L'utilisateur selon les privilèges qu'il dispose peut :
     <ul>
        <li>Créer un compte user</li>
        <li>Supprimer ou Activer un compte si on est administrateur</li>
        <li>Definir les rôles d'un user si on est admin</li>
        <li>Consulter la liste des filières</li>
        <li>Ajouter une filière,modifier et supprimer une filière si user a le droit requis</li>
        <li>Ajouter un Stagiare,modifier et supprimer un stagiaire si user a le droit requis</li>
     </ul>
  </li>
  <li><h3>Connexion et compte</h3>
      l'utilisateur peut:
      <ul>
        <li>Créer un compte à partir de la page d'accueil</li>
        <li>Modifier son mot de pass s'il l'oublie</li>
        <li>Pour pouvoir se connecter l'utilisateur a besoin que son compte soit activer par l'admin</li>
      </ul>
  </li>
  <li><h3>Rôle et privilège des uers</h3>
      Il y a deux types d'utilisateurs:
      <ol>
        <li>Admin qui peut
          <ul>
            <li>Supprimer un compte,definir les droits de l'utilisateur,désactiver un compte</li>
            <li>Consulter,supprimer ,modifier (filière,stagiaire,user)</li>
          </ul>
        </li>
        <li>Visiteur qui peut:
           <ul>
              <li>Modifier quelques info sur son compte</li>
              <li>Consulter : filière,stagiaire,user</li>
           </ul>
        </li>
      </ol>
  </li>
  <li><h3>Organisation</h3>
     Le répertoire principale Gestion_Stagiaire contient :
     <ul>
        <li>Pages : un répertoire contenant que des fichiers .php</li>
        <li>image : qui contiendra les photos des stagaires</li>
        <li>Base de donnees : ReqInit.sql (requête de création de la BD et ses tables),ma database que j'ai exporté</li>
        <li>Les fichiers : index.php et seCon.php</li>
     </ul>
  </li>
  <li><h3>Autres</h3>
    Pour tester l'appli il faut faire quelques modifs:
    <ul>
      <li>soit Importer la BD qui se trouve dans le repertoire Base de donnees</li>
      <li>Créer une BD à partir du fichier ReqInit.sql</li>
      <li>Dans le fichier connBD.php changer les identifiants de connexion</li>
    </ul>
  </li>
  <li><h3>Aperçu</h3></li>
</ol>
