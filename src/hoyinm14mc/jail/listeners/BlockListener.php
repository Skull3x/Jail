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
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;

class BlockListener extends BaseListener{

	public function onBlockBreak(BlockBreakEvent $event){
		if($this->plugin->isJailed($event->getPlayer())){
			$event->getPlayer()->sendMessage("§eYou are not allowed to destroy the jail!\nAdded " . $this->getPlugin()->getConfig()->get("punish-additional-minutes") . " minutes as punishment.");
			$this->getPlugin()->punish($event->getPlayer(), $this->getPlugin()->getConfig()->get("punish-additional-minutes"));
			$event->setCancelled(true);
		}
	}

	public function onBlockPlace(BlockPlaceEvent $event){
		if($this->plugin->isJailed($event->getPlayer())){
			$event->getPlayer()->sendMessage("§eYou are not allowed to destroy the jail!\nAdded " . $this->getPlugin()->getConfig()->get("punish-additional-minutes") . " minutes as punishment.");
			$this->getPlugin()->punish($event->getPlayer(), $this->getPlugin()->getConfig()->get("punish-additional-minutes"));
			$event->setCancelled(true);
		}
	}

}
?>