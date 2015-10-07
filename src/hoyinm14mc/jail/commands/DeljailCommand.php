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
namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class DeljailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "deljail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.deljail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(!isset($args[0])){
                    return false;
                }
                $jail = $args[0];
                if($this->plugin->jailExists($jail) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cJail doesn't exist!"));
                    return true;
                }
                $t = $this->plugin->data->getAll();
                $result = true;
                foreach(array_keys($t) as $name){
                    if(isset($t[$name]["jail"]) && $t[$name]["jail"] == $jail){
                        if($result !== false){
                            $result = false;
                        }
                    }
                }
                if($result !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cUnable to delete jail.  Someone is still being jailed there!"));
                    return true;
                }
                $this->plugin->delJail($jail);
                $issuer->sendMessage($this->plugin->colourMessage("&6You deleted jail: &c".$jail."&6!"));
                return true;
            break;
        }
    }
    
}
?>