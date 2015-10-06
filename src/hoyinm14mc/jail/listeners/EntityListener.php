<?php

namespace hoyinm14mc\jail\listeners;

use hoyinm14mc\jail\bases\BaseListener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class EntityListener extends BaseListener{
    
    public function onDamage(EntityDamageEvent $event){
        if($event->getEntity() instanceof Player && $this->plugin->isJailed($event->getEntity())){
            $event->setCancelled(true);
        }
    }
    
    public function onTeleport(EntityTeleportEvent $event){
        if($event->getEntity() instanceof Player && $this->plugin->isJailed($event->getEntity())){
            $event->setCancelled(true);
        }
    }
    
}
?>