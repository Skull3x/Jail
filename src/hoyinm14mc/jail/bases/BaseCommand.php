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
namespace hoyinm14mc\jail\bases;

use hoyinm14mc\jail\Jail;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandExecutor;

abstract class BaseCommand extends PluginBase implements CommandExecutor{
    
    protected $plugin;
    
    public function __construct(Jail $plugin){
        $this->plugin = $plugin;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
    
}
?>