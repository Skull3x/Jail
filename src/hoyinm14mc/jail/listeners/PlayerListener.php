<?php

/*
 * This file is part of Jail.
 * Copyright (C) 2015 CyberCube-HK
 *
 * Jail is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jail is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jail. If not, see <http://www.gnu.org/licenses/>.
 */
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
			$this->plugin->data->setAll($t);
			$this->plugin->data->save();
		}
		if($this->getPlugin()->isJailed($event->getPlayer()) && $t[$event->getPlayer()->getName()]["minutes"] < 0){
			$event->getPlayer()->sendMessage($this->plugin->colourMessage("&6You have been unjailed!"));
			$this->getPlugin()->unjail($event->getPlayer());
		}
		if($this->plugin->isJailed($event->getPlayer())){
			$event->getPlayer()->sendPosition(new Position($j[$t[$event->getPlayer()->getName()]["jail"]]["x"], $j[$t[$event->getPlayer()->getName()]["jail"]]["y"], $j[$t[$event->getPlayer()->getName()]["jail"]]["z"], $this->plugin->getServer()->getLevelByName($j[$t[$event->getPlayer()->getName()]["jail"]]["world"])));
		}
		$this->plugin->data->setAll($t);
		$this->plugin->data->save();
	}

	public function onCmd(PlayerCommandPreprocessEvent $event){
		$msg = $event->getMessage();
		if($msg{0} == "/" && $msg != "/bail"){
			if($this->plugin->isJailed($event->getPlayer())){
				$event->getPlayer()->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
				$event->setCancelled(true);
			}
		}
	}

	public function onInteract(PlayerInteractEvent $event){
	    $available_blocks = [323, 63, 68];
		if($this->plugin->isJailed($event->getPlayer())){
		    $cancel = true;
		    foreach($available_blocks as $id){
		        if($event->getBlock()->getID() == $id){
		            $cancel = false;
		        }
		    }
			if($cancel !== false) $event->setCancelled(true);
		}
	}

	public function onPlayerRespawn(PlayerRespawnEvent $event){
		if($this->plugin->hasPlayedBefore($event->getPlayer()) && $this->plugin->isJailed($event->getPlayer())){
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