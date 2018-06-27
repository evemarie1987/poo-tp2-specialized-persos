<?php 


abstract class Character
{
	protected $id;
	protected $name;
	protected $damaged;
	protected $type;
	protected $asset;
	protected $timeAsleep;
	protected $level;
	protected $experience;
	protected $strength;
	protected $lastConnected;
	protected $numberOfHits;
	protected $lastHitDate;
	
	const DEAD = 1;
	const HIT = 2;
	const ME = 3;
	const ASLEEP = 4;
	const NO_MAGIC = 5;
	const MAX_HITS = 6;

	public function getId()
	{
		return $this->id;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getDamaged()
	{
		return $this->damaged;
	}
	public function getType()
	{
		return $this->type;
	}
	public function getAsset()
	{
		return $this->asset;
	}
	public function getTimeAsleep()
	{
		return $this->timeAsleep;
	}
	public function getLevel() {
		return $this->level;
	}
	public function getExperience()
	{
		return $this->experience;
	}
	public function getStrength()
	{
		return $this->strength;
	}
	public function getNumberOfHits()
	{
		return $this->numberOfHits;
	}
	public function getLastHitDate()
	{
		return $this->lastHitDate->format('Y-m-d');
	}
	public function getLastConnected()
	{
		return $this->lastConnected->format('Y-m-d');
	}

	public function __construct($data = []) 
	{
		$this->type = strtolower(static::class);
		$this->lastHitDate = new DateTime();
		$this->hydrate($data);
		if ($this->lastHitDate->diff(new DateTime())->days >= 1) {
			$this->setNumberOfHits(0);
		}
	}

	public function hydrate($data)
	{
		foreach ($data as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}
	
	public function setName($name)
	{
		if (is_string($name)) {
			$this->name = $name;
		} else {
			throw new Exception("Le nom du personnage doit être une chaine de caractère");
		}
	}
	public function setId($id)
	{
		if ($id > 0) {
			$this->id = (int)$id;
		} else {
			throw new Exception("Identifiant de personnage invalide");
		}
	}
	public function setDamaged($damaged)
	{
		$damaged = (int) $damaged;
		if ($damaged >= 0 && $damaged <= 100) {
			$this->damaged = $damaged;
		} else {
			throw new Exception("Les points de dégats doivent être compris entre 0 et 100");
		}
	}
	public function setTimeAsleep($timeAsleep)
	{
		if ($timeAsleep <= time()) {
			$this->timeAsleep = time();
		} else {
			$this->timeAsleep = (int)$timeAsleep;
		}
	}
	public function setAsset($asset)
	{
		$this->asset = (int)$asset;
	}
	public function setLevel($level)
	{
		$this->level = (int)$level;
	}
	public function setExperience($experience)
	{
		$experience = (int)$experience;
		if ($experience >= 0 and $experience < 100) {
			$this->experience = $experience;
		} else {
			throw new Exception("L'expérience doit être comprise entre 0 et 100 exclus");
		}
	}
	public function setStrength($strength)
	{
		$strength = (int)$strength;
		if ($strength >= 5) {
			$this->strength = $strength;
		} else {
			throw new Exception("La force du personnage doit être supérieure à cinq");
		}
	}
	public function setNumberOfHits($numberOfHits)
	{
		$numberOfHits = (int)$numberOfHits;
		if ($numberOfHits >= 0 && $numberOfHits <= 3) {
			$this->numberOfHits = $numberOfHits;
		} else {
			throw new Exception("Le nombre de coups portés doit être entre 0 et 3");
		}
	}
	public function setLastHitDate($lastHitDate)
	{
		$this->lastHitDate = new DateTime($lastHitDate);
	}
	public function setLastConnected($lastConnected)
	{
		$this->lastConnected = new DateTime($lastConnected);
	}

	public function damageUp($damagePoints)
	{
		$this->damaged += $damagePoints;
		$this->updateAsset();
		if ($this->damaged > 100) {
			return self::DEAD;
		} else {
			return self::HIT;
		}
	}

	public function hit(Character $target)
	{
		if ($this->id == $target->getId()) {
			return self::ME;
		} elseif ($this->timeAsleep > time()) {
			return self::ASLEEP;
		} elseif ($this->numberOfHits >= 3) {
			return self::MAX_HITS;
		} 
		else {
			$this->hitsUp();
			$result = $target->damageUp($this->strength);
			switch ($result) {
				case self::HIT:
					$this->experienceUp(3);
					break;
				case self::DEAD:
					$this->experienceUp(4);
					break;
			}
		} 
	}

	public function experienceUp($experiencesPoints)
	{
		$this->experience += $experiencesPoints;
		if ($this->experience >= 100) {
			$this->levelUp();
		}
	}
	public function levelUp()
	{
		$this->level++;
		$this->strength += 3;
		$this->experience = $this->experience % 100;
	}
	public function hitsUp()
	{
		$this->numberOfHits++;
		$this->lastHitDate = new DateTime();
	}

	public function startUsing()
	{
		if ($this->lastConnected->diff(new DateTime)->days >= 1) {
			$this->damaged -= 10;
		}
		$this->updateAsset();
		$this->lastConnected = new DateTime();
	}

	public function updateAsset()
	{
		if ($this->damaged <= 25) {
			$this->asset = 4;
		} elseif ($this->damaged <= 50) {
			$this->asset = 3;
		} elseif ($this->damaged <= 75) {
			$this->asset = 2;
		} elseif ($this->damaged <= 90) {
			$this->asset = 1;
		} else {
			$this->asset = 0;
		}
	}

	public function fallAsleep($timeAsleep)
	{
		if ($this->timeAsleep <= time()) {
			$this->timeAsleep = time();
		}
		$this->timeAsleep += (int) $timeAsleep;
		return self::ASLEEP;
	}

}