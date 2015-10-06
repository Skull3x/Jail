<?php

namespace hoyinm14mc\jail\listeners;

use hoyinm14mc\jail\bases\BaseListener;
use pocketmine\level\Position;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;

class BlockListener extends BaseListener{
    
    public function onBlockBreak(BlockBreakEvent $event){
        if($this->plugin->isJailed($event->getPlayer())){
            $event->setCancelled(true);
        }
    }
    
    public function onBlockPlace(BlockPlaceEvent $event){
        if($this->plugin->isJailed($event->getPlayer())){
            $event->setCancelled(true);
        }
    }
    
}
?>