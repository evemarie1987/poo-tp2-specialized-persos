<?php
try {
	
	include 'utilities.php';
	include 'controllers.php';
	spl_autoload_register('loadClass');


	session_start();
	if (array_key_exists('message', $_SESSION)) {
		unset($_SESSION['message']);
	}

	$db = new PDO(
		'mysql:host=projets.local;dbname=openclassrooms;charset=UTF8', 
		'openclassrooms', 
		'', 
		[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
	);

	$characterManager = new CharacterManager($db);

	if (array_key_exists('logout', $_GET)) {
		logout();
	}

	if (array_key_exists('action', $_POST)) {
		if (array_key_exists('name', $_POST) && array_key_exists('type', $_POST)) {
			$perso = characterAction($_POST['action'], $_POST['name'], $_POST['type'], $characterManager);
		} else {
			debug($_POST);
			throw new Exception("Remplissage incorrect de formulaire (tous les champs n'existent pas)");
		}
	}

	elseif (array_key_exists('id', $_SESSION)) {

		$perso = $characterManager->useCharacter($_SESSION['id']);

		if (array_key_exists('hit', $_GET)) {
			hit($perso, (int)$_GET['hit'], $characterManager);
		}
		elseif (array_key_exists('spell', $_GET)) {
			spell($perso, (int)$_GET['spell'], $characterManager);
		}
	}


	$characters = $characterManager->list();

	$numberOfCharacters = $characterManager->count();
	if (array_key_exists('message', $_SESSION)) {
		$message = $_SESSION['message'];
	}
	require 'View.php';
} catch (Exception $e) {
	include 'errorView.php';
}
