<?php 
/**
* 
*/
class Magicien extends Character
{
	public function setNumberOfHits($numberOfHits)
	{
		$numberOfHits = (int)$numberOfHits;
		if ($numberOfHits >= 0 && $numberOfHits <= 5) {
			$this->numberOfHits = $numberOfHits;
		} else {
			throw new Exception("Le nombre de coups portés doit être entre 0 et 3");
		}
	}

	public function spell(Character $target)
	{
		if ($this->numberOfHits >= 5) {
			return self::MAX_HITS;
		} elseif ($this->id == $target->getId()) {
			return self::ME;
		} elseif ($this->timeAsleep > time()) {
			return self::ASLEEP;
		} elseif ($this->asset <= 0) {
			return self::NO_MAGIC;
		} else {
			$this->experienceUp(2);
			$this->hitsUp();
			return $target->fallAsleep(($this->asset * 6) * 3600);
		}
	}
}