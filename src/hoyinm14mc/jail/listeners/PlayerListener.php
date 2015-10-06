<?php

namespace hoyinm14mc\jail\listeners;

use hoyinm14mc\jail\bases\BaseListener;
use pocketmine\level\Position;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerRespawnEvent;

class PlayerListener extends BaseListener{
    
    public function onPlayerJoin(PlayerJoinEvent $event){
        $t = $this->plugin->data->getAll();
        $j = $this->plugin->data2->getAll();
        if($this->plugin->hasPlayedBefore($event->getPlayer()) !== true){
            $t[$event->getPlayer()->getName()]["jailed"] = false;
        }
        if(isset($t[$event->getPlayer()->getName()]["need-tp"])){
            $event->getPlayer()->teleport($event->getPlayer()->getLevel()->getSafeSpawn());
            $event->getPlayer()->sendMessage($this->plugin->colourMessage("&6You have been unjailed!"));
        }
        if($this->plugin->isJailed($event->getPlayer())){
            $event->getPlayer()->sendPosition(new Position($j[$t[$event->getPlayer()->getName()]["jail"]]["x"], $j[$t[$event->getPlayer()->getName()]["jail"]]["y"], $j[$t[$event->getPlayer()->getName()]["jail"]]["z"], $this->plugin->getServer()->getLevelByName($j[$t[$event->getPlayer()->getName()]["jail"]]["world"])));
        }
        $this->plugin->data->setAll($t);
        $this->plugin->data->save();
    }
    
    public function onCmd(PlayerCommandPreprocessEvent $event){
        $msg = $event->getMessage();
        if($msg{0} == "/"){
            if($this->plugin->isJailed($event->getPlayer())){
                $event->getPlayer()->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                $event->setCancelled(true);
            }
        }
    }
    
    public function onInteract(PlayerInteractEvent $event){
        if($this->plugin->isJailed($event->getPlayer())){
            $event->setCancelled(true);
        }
    }
    
    public function onPlayerRespawn(PlayerRespawnEvent $event){
        if($this->plugin->isJailed($event->getPlayer())){
            $t = $this->getPlugin()->data->getAll();
            $j = $this->getPlugin()->data2->getAll();
            $jail = $t[$event->getPlayer()->getName()]["jail"];
            if($this->getPlugin()->jailExists($jail)){
                $event->setRespawnPosition(new Position($j[$jail]["x"], $j[$jail]["y"], $j[$jail]["z"], $this->getPlugin()->getServer()->getLevelByName($j[$jail]["world"])));
            }
        }
    }
    
}
?>