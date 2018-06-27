<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Balises Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>Mini-jeu</title>

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
		<p>Nombres de personnages créés : <?= $numberOfCharacters ?></p>
		<?php if (isset($message)): ?>
			<p><?= $message ?></p>
		<?php endif ?>
		<?php if (isset($perso)): ?>
			<div class="fieldset">
				<h4><?= htmlspecialchars($perso->getName()) ?>, <?= translateType($perso->getType()) ?></h4>
				<ul>
					<li>Dégats : <?= $perso->getDamaged() ?></li>
					<li>Atout : <?= $perso->getAsset() ?></li>
					<li>Niveau : <?= $perso->getLevel() ?></li>
					<li>Expérience : <?= $perso->getExperience() ?> / 99</li>
					<li>Force : <?= $perso->getStrength() ?></li>
					<li>Coups portés : <?= min(3, $perso->getNumberOfHits()) ?> / 3</li>
					<?php if ($perso->getType() == 'magicien'): ?>
						<li>Vous pouvez encore lancer <?= 5-$perso->getNumberOfHits() ?> sorts. S'il vous reste encore des coups, un sort vous en coutera un.</li>
					<?php endif ?>
				</ul>
				<a href="?logout">Se déconnecter</a>
			</div>
			<div class="fieldset">
				<?php if ($perso->getTimeAsleep() <= time()): ?>
					<h4>Vos adversaires</h4>
					<ul>
						<?php foreach ($characters as $character): ?>
							<?php if ($character->getId() != $perso->getId()): ?>
								<li>
									<?= htmlspecialchars($character->getName()) ?> (<?= translateType($character->getType()) ?>), <?= $character->getDamaged() ?> points de dégats, niveau <?= $character->getLevel() ?> : 
									<a href="?hit=<?= $character->getId()?>">Attaquer</a>
									<?php if ($perso->getType() == 'magicien'): ?>
										| <a href="?spell=<?= $character->getId()?>">Endormir</a>
									<?php endif ?>
								</li>
							<?php endif ?>
						<?php endforeach ?>
					</ul>
				<?php else: ?>
					<p>Vous êtes endormi, revenez dans <?= convertToHours($perso->getTimeAsleep())?>
				<?php endif ?>
			</div>
		<?php else: ?>
			<form method="post" class="fieldset">
				<label for="name">Nom de votre personnage</label>
				<input type="text" name="name" id="name">
				<button name="action" value="use">Utiliser</button>
				<label for="type">Type de personnage</label>
				<select name="type" id="type">
					<option value="1">Magicien</option>
					<option value="2">Guerrier</option>
				</select>
				<button name="action" value="create">Créer</button>
			</form>
		<?php endif ?>
	</main>
	
	<!-- FOOTER --> 
	<footer>
		<small><a href="https://openclassrooms.com/courses/programmez-en-oriente-objet-en-php/tp-mini-jeu-de-combat">Exercice d'openclassrooms - POO en PHP</a> - Eve-Marie TALON, <em>4 janvier 2018</em></small><br>
		<small><em>dernière mise à jour le 5 janvier 2018</em></small>
	</footer>
</body>
</html>