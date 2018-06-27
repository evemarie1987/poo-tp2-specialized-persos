<?php 

function debug($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function loadClass($className)
{
	$filename = __DIR__.'/classes/'.$className.'.class.php';
	if (file_exists($filename)) {
		require $filename;
	}
}

function convertToHours($timeAsleep) {
	$numberOfSeconds = $timeAsleep - time();

	$hours = floor($numberOfSeconds / 3600);
	$minutes = floor(($numberOfSeconds / 60) % 60);
	$seconds = $numberOfSeconds % 60;

	return $hours.' heures '.$minutes.' minutes '.$seconds.' secondes';
}

function translateType($type) {
	switch ($type) {
		case 'magicien':
			return 'Magicien';
			break;
		case 'warrior':
			return 'Guerrier';
			break;
	}
}