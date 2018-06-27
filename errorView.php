<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Balises Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>Erreur</title>

	<!-- Libraries CSS et polices -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Petit+Formal+Script">
	<link rel="stylesheet" href="css/font-awesome.css">

	<!-- Feuille CSS du projet -->
	<link rel="stylesheet" href="css/base.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<!-- HEADER -->
	<header id="masthead">
		<h1><a href="./"><i class="fa fa-home"></i> Jeu de combat de personnages</a></h1>
	</header>
	
	<!-- MAIN CONTENT -->
	<main class="container vignette">
		<p class="error"><?= $e->getMessage() ?></p>
	</main>
	
	<!-- FOOTER --> 
	<footer>
		<small>Eve-Marie TALON</small>
	</footer>
</body>
</html>