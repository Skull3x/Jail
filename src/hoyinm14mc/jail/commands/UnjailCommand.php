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

class UnjailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "unjail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.unjail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(!isset($args[0])){
                    return false;
                }
                $target = $this->plugin->getServer()->getPlayer($args[0]);
                if($target === null){
                    $issuer->sendMessage($this->plugin->colourMessage("&cInvalid target!"));
                    return true;
                }
                if($this->plugin->isJailed($target) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cTarget is not jailed!"));
                    return true;
                }
                $this->plugin->unjail($target);
                $issuer->sendMessage($this->plugin->colourMessage("&6You unjailed &e".$target->getName()." &6!"));
                $target->sendMessage($this->plugin->colourMessage("&6You have been unjailed!"));
                return true;
            break;
        }
    }
    
}
?>