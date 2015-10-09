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
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\tile\Sign;

class BlockListener extends BaseListener{

	  public function onSignChange(SignChangeEvent $event){
	      if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68){
	        		$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
        			if(! $sign instanceof Sign){
	           			return;
        			}
        			$sign = $event->getLines();
        			if($sign[0] == '[Bail]' || $sign[0] == "&6[&4Bail&6]" || $sign[0] == '§6[§4Bail§6]'){
        			    if($event->getPlayer()->hasPermission("jail.sign.create") || $event->getPlayer()->hasPermission("jail.sign.create.bail")){
        			        $event->setLine(0, "§6[§4Bail§6]");
        			        $event->getPlayer()->sendMessage($this->getPlugin()->colourMessage("&aYou created a bail sign!"));
        			    }else{
        			        $event->setLine(0, null);
							     			$event->setLine(1, null);
						     				$event->setLine(2, null);
					     					$event->setLine(3, null);
        			        $event->getPlayer()->sendMessage($this->getPlugin()->colourMessage("&cYou don't have permission for this!"));
        			    }
        			}
       }
	  }
	  
	  public function onBlockBreak(BlockBreakEvent $event){
	     if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68){
    		$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
    		if(! $sign instanceof Sign){
    				return;
	   		}
   			$sign = $sign->getText();
   			if($sign[0] == '§6[§4Bail§6]'){
		      		if($event->getPlayer()->hasPermission("jail.sign.destroy") || $event->getPlayer()->hasPermission("jail.sign.destroy.bail")){
		      		    $event->getPlayer()->sendMessage($this->getPlugin()->colourMessage("&aYou destroyed a bail sign!"));
	         }else{
	             $issuer->sendMessage($this->getPlugin()->colourMessage("&cYou don't have permission for this!"));
	         }
	     }
	   }
  }

}
?>