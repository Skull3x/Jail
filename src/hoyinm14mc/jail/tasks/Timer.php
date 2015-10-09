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

class Timer extends BaseTask{

	public function onRun($tick){
		$t = $this->plugin->data->getAll();
		foreach(array_keys($t) as $name){
			if($t[$name]["jailed"] === true){
				$t[$name]["seconds"] = (int) $t[$name]["seconds"] - 1;
				$this->plugin->data->setAll($t);
				$this->plugin->data->save();
				if($t[$name]["seconds"] < 0){
					$target = $this->plugin->getServer()->getPlayer($name);
					if($t[$name]["minutes"] == 0 && $t[$name]["seconds"] < 0){
						if($target !== null){
							$this->plugin->unjail($target);
							$target->sendMessage($this->plugin->colourMessage("&l&aTIME'S UP!\n&6You have been unjailed!"));
						}
					} else{
						$t[$name]["minutes"] = $t[$name]["minutes"] - 1;
						$t[$name]["seconds"] = 59;
						$this->plugin->data->setAll($t);
						$this->plugin->data->save();
					}
				}
			}
		}
	}

}
?>