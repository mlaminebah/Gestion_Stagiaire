<?php session_start ();?>
<nav class="navbar navbar-expand-sm navbar-dark bg-secondary navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="../index.php" class="navbar-brand">Gestion des Stagiaires</a>
		</div>
		<!-- Toggler/collapsibe Button -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Navbar links -->
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="nav navbar-nav">
			<li class="nav-item">
				<a class ="nav-link text-white" href="stagiaires.php">Les Stagiaiers</a>
			</li>
			<li class="nav-item">
				<a class ="nav-link text-white" href="filieres.php">Les Filières</a>
			</li>
			<li class="nav-item">
				<a class ="nav-link text-white" href="utilisateurs.php">Les Utilisateurs</a>
			</li>
			</ul>
			<ul class="navbar-nav ml-auto flex-nowrap">
				<li class="nav-item"><a href="editerUser.php?log=<?php echo $_SESSION['user']['login'];?>&email=
					<?php echo $_SESSION['user']['email'];?>&role=<?php echo $_SESSION['user']['role'];?>&etat=<?php
					echo $_SESSION['user']['etat'];?>" class ="nav-link text-white"><i class="fas fa-user"></i>&nbsp;<?php echo $_SESSION['user']['login'];?></i></a></li>
				<li class="nav-item"><a href="seDeconnecter.php" class ="nav-link text-white"><i class="fas fa-sign-out-alt"></i>&nbsp;Deconnexion</a></li>
			</ul>
		</div>
	</div>
</nav>
