<?php 
/**
* 
*/
class Warrior extends Character
{
	public function damageUp($damagePoints)
	{
		$this->experienceUp(1);
		$this->damaged += $damagePoints - $this->asset;
		$this->updateAsset();
		if ($this->damaged > 100) {
			return self::DEAD;
		} else {
			return self::HIT;
		}
	}

	public function hit(Character $target)
	{
		$result = parent::hit($target);
		if ($result == self::HIT || $result == self::DEAD) {
			$this->experienceUp(1);
		}
		return $result;
	}
	
}