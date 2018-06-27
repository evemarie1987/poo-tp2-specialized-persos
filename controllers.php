<?php 
function logout()
{
	$_SESSION = [];
	session_destroy();
	header('Location: ./');
	exit();
}


function create($name, $type, CharacterManager $characterManager) {
	if(!$characterManager->doesCharacterExist($name)) {	
		switch ($type) {
			case 1:
				$perso = new Magicien(['name' => $name]);
				break;
			case 2:
				$perso = new Warrior(['name' => $name]);
				break;
			
			default:
				throw new Exception("Remplissage incorrct du formulaire(type de personnage)");
				break;
		}
		$characterManager->add($perso);
		return $perso;
	} else {
		$_SESSION['message'] = 'Ce personnage existe déjà';
		return;
	}
}

function characterAction($action, $name, $type, CharacterManager $characterManager)
{	
	if (!empty($name)) {
		switch ($action) {
			case 'create':
				$perso = create($name, $type, $characterManager);
				break;

			case 'use':
				if ($characterManager->doesCharacterExist($name)) {
					$perso = $characterManager->useCharacter($name);
				} else {
					$_SESSION['message'] = 'Ce personnage n\'existe pas ou plus';
					return;
				}
				break;

			default:
				throw new Exception("Utilisation incorrecte du formulaire");
				break;
		}
		$_SESSION['id'] = $perso->getId();
		return $perso;
	} else {
		$_SESSION['message'] = 'Entrer un nom dans le formulaire';
	}
}


function hit(Character $perso, int $target_id, CharacterManager $characterManager)
{
	if ($characterManager->doesCharacterExist($target_id)) {
		$target = $characterManager->getCharacter($target_id);
		$result = $perso->hit($target);
		switch ($result) {
			case Character::DEAD:
				$_SESSION['message'] = 'Le personnage '.$target->getName().' est mort';
				$characterManager->delete($target->getId());
				$characterManager->update($perso);
				break;
			case Character::HIT:
				$_SESSION['message'] = 'Vous avez frappé le personnage '.$target->getName();
				$characterManager->update($target);
				$characterManager->update($perso);
				break;
			case Character::ME:
				throw new Exception("Vous ne pouvez pas vous attaquer vous-même");
				break;
			case Character::MAX_HITS:
				$_SESSION['message'] = 'Vous ne pouvez plus attaquer aujourd\'hui !';
				break;
			case Character::ASLEEP:
				$_SESSION['message'] = 'Malheureusement, vous êtes endormi et ne pouvez pas attaquer.';
				break;
			default:
				throw new Exception("Retour impossible de l'attaque");
				break;
		}
	} else {
		$_SESSION['message'] = 'Le personnage attaqué n\' existe pas ou plus';
	}
}

function spell(Character $perso, int $target_id, CharacterManager $characterManager)
{
	if ($perso->getType() != 'magicien') {
		throw new Exception("Quelqu'un qui n'est pas un magicien essaie de lancer un sort ! ");
	}
	if ($characterManager->doesCharacterExist($target_id)) {
		$target = $characterManager->getCharacter($target_id);
		$result = $perso->spell($target);
		switch ($result) {
			case Character::ASLEEP:
				$_SESSION['message'] = 'Vous avez endormi le personnage '.$target->getName();
				$characterManager->update($target);
				$characterManager->update($perso);
				break;
			case Character::NO_MAGIC:
				$_SESSION['message'] = 'Vous ne pouvez pas attaquer si vous n\'avez plus de magie';
				break;
			case Character::ME:
				throw new Exception("Vous ne pouvez pas vous ensorceler vous-même");
				break;
			case Character::ASLEEP:
				$_SESSION['message'] = 'Malheureusement, vous êtes endormi et ne pouvez pas lancer de sorts.';
				break;
			default:
				throw new Exception("Retour impossible du sort");
				break;
		}
	} else {
		$_SESSION['message'] = 'Le personnage attaqué n\' existe pas ou plus';
	}
}