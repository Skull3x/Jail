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
namespace hoyinm14mc\jail\tasks;

use hoyinm14mc\jail\bases\BaseTask;
use pocketmine\scheduler\PluginTask;

class TipBroadcaster extends BaseTask{
    
    public function onRun($tick){
        $t = $this->plugin->data->getAll();
        foreach(array_keys($t) as $name){
            $player = $this->plugin->getServer()->getPlayer($name);
            if($player !== null && $this->plugin->isJailed($player) !== false){
                $player->sendTip($this->plugin->colourMessage("&cYou have been jailed!\n&r&6Time left: &e".($t[$name]["minutes"] < 10 ? "0" : "").$t[$name]["minutes"]."&b:&e".($t[$name]["seconds"] < 10 ? "0" : "").$t[$name]["seconds"]." &7mins:secs"));
            }
        }
    }
    
}
?>