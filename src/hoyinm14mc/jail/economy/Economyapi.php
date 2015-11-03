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
namespace hoyinm14mc\jail\economy;

use hoyinm14mc\jail\bases\BaseEconomy;
use pocketmine\Player;

class Economyapi extends BaseEconomy{
    
    public function bail(Player $player){
        if($this->getPlugin()->isJailed($player) !== true){
            $player->sendMessage($this->getPlugin()->colourMessage("&cYou are not jailed!"));
            return false;
        }
        $t = $this->getPlugin()->data->getAll();
        $money = $this->getPlugin()->getEco()->getInstance()->myMoney($player);
	     	if($money < ($this->getConfig()->get("money-per-minute")*($t[$player->getName()]["minutes"]+1))){
	        		$player->sendMessage($this->getPlugin()->colourMessage("&cYou don't have enough money to bail!\n&cYou need " . $this->getConfig()->get("money-per-minute")*($t[$player->getName()]["minutes"]+1)));
	        		return false;
     		}
     		$this->getPlugin()->getEco()->getInstance()->reduceMoney($player, $this->getPlugin()->getConfig()->get("money-per-minute")*($t[$player->getName()]["minutes"]+1));
     		$this->getPlugin()->unjail($player);
     		$player->sendMessage($this->getPlugin()->colourMessage("&aYou have been unjailed successfully!"));
     		$player->sendMessage("Bank : -$" . $this->getConfig()->get("money-per-minute") * ($t[$player->getName()]["minutes"]+1) . " | $" . $this->getPlugin()->getEco()->getInstance()->myMoney($player) . " left");
	     	return true;
    }
    
}
?>