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
namespace hoyinm14mc\jail\listeners\sign;

use hoyinm14mc\jail\bases\BaseListener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;

class PlayerListener extends BaseListener{

	  public function onPlayerInteract(PlayerInteractEvent $event){
	      if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 68 || $event->getBlock()->getID() == 63){
	          $sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
       			if(! $sign instanceof Sign){
          				return;
       			}
       			$sign = $sign->getText();
       			if($sign[0] == '§6[§4Bail§6]'){
       			    if($this->getPlugin()->isJailed($event->getPlayer())){
       			        if($event->getPlayer()->hasPermission("jail.sign.toggle") || $event->getPlayer()->hasPermission("jail.sign.toggle.bail")){
       			            $this->getPlugin()->getServer()->dispatchCommand($event->getPlayer(), "bail");
       			        }else{
       			            $event->getPlayer()->sendMessage("§cYou don't have permission for this!");
       			        }
       			    } else{
       			        $event->getPlayer()->sendMessage($this->getPlugin()->colourMessage("You are not jailed!"));
       			    }
       			}
	      }
	  }

}
?>