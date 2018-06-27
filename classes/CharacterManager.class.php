<?php 


class CharacterManager
{
	private $db;

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function setDb(PDO $db)
	{
		$this->db = $db;
	}

	public function add(Character $perso)
	{
		$query = $this->db->prepare('
			INSERT INTO gamecharacter
				(name, type, timeAsleep)
			VALUES
				(?, ?, ?)
		');
		$query->execute([$perso->getName(), $perso->getType(), time()]);
		$perso->hydrate([
			'id' => $this->db->lastInsertId(),
			'damaged' => 0,
			'asset' => 4,
			'timeAsleep' => time(),
			'level' => 1,
			'experience' => 0,
			'strength' => 5,
			'numberOfHits'=> 0,
			'lastHitDate' => new DateTime(),
			'lastConnected' => new DateTime()
		]);
	}

	public function update(Character $perso)
	{
		$query = $this->db->prepare('
			UPDATE `gamecharacter` 
			SET 
			 `damaged`= ?,
			 asset = ?,
			 timeAsleep = ?,
			 level = ?, 
			 experience = ?, 
			 strength = ?, 
			 numberOfHits = ?,
			 lastHitDate = ?,
			 lastConnected = ?
			WHERE id = ?
		');
		$query->execute([
			$perso->getDamaged(), 
			$perso->getAsset(), 
			$perso->getTimeAsleep(), 
			$perso->getLevel(), 
			$perso->getExperience(), 
			$perso->getStrength(), 
			$perso->getNumberOfHits(),
			$perso->getLastHitDate(),
			$perso->getLastConnected(),
			$perso->getId()
		]);
	}

	public function getCharacter($info)
	{
		if (is_int($info)) {
			$query = $this->db->prepare('
				SELECT *
				FROM gamecharacter
				WHERE id = ?
			');
		} else {
			$query = $this->db->prepare('
				SELECT *
				FROM gamecharacter
				WHERE name = ?
			');
		}
		$query->execute([$info]);
		$data = $query->fetch(PDO::FETCH_ASSOC);
		if ($data != null) {
			$characterClass = ucfirst($data['type']);
			return new $characterClass($data);
		}
	}

	public function delete($info)
	{
		if (is_int($info)) {
			$query = $this->db->prepare('
				DELETE FROM gamecharacter
				WHERE id = ?
			');
		} else {
			$query = $this->db->prepare('
				DELETE FROM gamecharacter
				WHERE name = ?
			');
		}
		return $query->execute([$info]);
	}

	public function list() {
		$query = $this->db->prepare('
			SELECT *
			FROM gamecharacter
		');
		$query->execute();
		$datas = $query->fetchAll(PDO::FETCH_ASSOC);
		$characters = [];
		foreach ($datas as $data) {
			$characterClass = ucfirst($data['type']);
			array_push($characters, new $characterClass($data));
		}
		return $characters;
	}

	public function count()
	{
		$query = $this->db->prepare('
			SELECT COUNT(*)
			FROM gamecharacter
		');
		$query->execute();
		return $query->fetchcolumn();
	}

	public function doesCharacterExist($info)
	{
		if (is_int($info)) {
			$query = $this->db->prepare('
				SELECT *
				FROM gamecharacter
				WHERE id = ?
			');
		} else {
			$query = $this->db->prepare('
				SELECT *
				FROM gamecharacter
				WHERE name = ?
			');
		}
		$query->execute([$info]);
		return (!empty($query->fetch()));
	}

	public function useCharacter($info)
	{
		$perso = $this->getCharacter($info);
		$perso->startUsing();
		$this->update($perso);
		return $perso;
	}
}