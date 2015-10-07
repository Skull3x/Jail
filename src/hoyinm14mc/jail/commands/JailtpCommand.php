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

class JailtpCommand extends BaseCommand{

	public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
		switch($cmd->getName()){
			case "jailtp":
				if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.jailtp") !== true){
					$issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
					return true;
				}
				if(! isset($args[0])){
					return false;
				}
				$jail = $args[0];
				if($this->plugin->jailExists($jail) !== true){
					$issuer->sendMessage($this->plugin->colourMessage("&cJail doesn't exist!"));
					return true;
				}
				if(! $issuer instanceof Player){
					$issuer->sendMessage($this->plugin->colourMessage("Command only works in-game!"));
					return true;
				}
				$this->plugin->teleportToJail($issuer, $jail);
				$issuer->sendMessage($this->plugin->colourMessage("&6You have been teleported to jail &c" . $jail));
				return true;
			break;
		}
	}

}
?>