<?php

namespace DidntPot;

use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\data\Data;

class LargeFireball extends FireBall{

	const NETWORK_ID = Data::NETWORK_IDS["large_fireball"];

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null, bool $critical = false){

		$this->height = Data::HEIGHTS[self::NETWORK_ID];
		$this->width = Data::WIDTHS[self::NETWORK_ID];
		
		parent::__construct($level, $nbt, $shootingEntity, $critical);

	}
}