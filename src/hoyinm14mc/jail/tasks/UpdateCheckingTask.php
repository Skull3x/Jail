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

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\UpdateChecker;
use hoyinm14mc\jail\bases\BaseTask;

class UpdateCheckingTask extends BaseTask{

	public function onRun($tick){
		if($this->getPlugin()->getConfig()->get("auto-update-checker") !== false){
			$this->getPlugin()->getLogger()->info("Checking for update..");
			$updatechecker = new UpdateChecker($this->getPlugin(), $this->getPlugin()->getConfig()->get("default-channel"));
			$updatechecker->checkUpdate();
		}
	}

}
?>