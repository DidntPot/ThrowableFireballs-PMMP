<?php

declare(strict_types = 1);

namespace DidntPot;


use pocketmine\plugin\PluginBase;
use pocketmine\{Server, Player};
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\UseItemPacket;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\{
TextPacket, LevelSoundEventPacket, LevelSoundEvent
};
use pocketmine\event\player\{PlayerInteractEvent};
use pocketmine\event\entity\{EntityLevelChangeEvent, EntityDamageEvent, EntityExplodeEvent};
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\network\mcpe\protocol\AddItemEntityPacket;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\math\Vector3;
use pocketmine\entity\projectile\ProjectileSource;
use pocketmine\level\Level;
use pocketmine\level\Location;

use DidntPot\LargeFireball;

class Main extends PluginBase implements Listener {
 
    
    public function onEnable() : void{

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
    	$this->registerFireballEntity();

	}

	public function registerFireballEntity() : void{

		Entity::registerEntity(LargeFireball::class, true);
		Entity::registerEntity(Fireball::class, true);

	}
	
    public function onInteract(PlayerInteractEvent $event){

	    $player = $event->getPlayer();
        $item = $event->getItem();
	    $itemname = $item->getCustomName();
	    $player = $player;
        if($item->getId() == 385){

		$x = $player->getX(); //Gets X Position
		$y = $player->getY(); //Gets Y Position
		$z = $player->getZ(); //Gets Z Position

		$level = $player->getLevel();

		$entity = Entity::createBaseNBT(new Vector3($player->getX(), $player->getY(), $player->getZ()));
		$entity->setMotion($entity->getDirectionVector()->normalize()->multiply(2)); 
		$fireball = new LargeFireball($player->level, $entity, $player);
		$fireball->setExplode(true);
		$launch = new ProjectileLaunchEvent($fireball);
		$launch->call();

		if($launch->isCancelled()){
			$fireball->kill();
		}else{
			$fireball->spawnToAll();
            $level = $player->getLevel();
            $level->broadcastLevelSoundEvent(new Vector3($player->getX(), $player->getY(), $player->getZ()), LevelSoundEventPacket::SOUND_BLOCK_TURTLE_EGG_HATCH);
			}
		}
	    return true;

    }
}
