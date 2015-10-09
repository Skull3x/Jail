<?php

/*
 * This file is the main class of Jail.
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
namespace hoyinm14mc\jail;

use hoyinm14mc\jail\listeners\PlayerListener;
use hoyinm14mc\jail\listeners\BlockListener;
use hoyinm14mc\jail\listeners\EntityListener;
use hoyinm14mc\jail\listeners\sign\PlayerListener as SignPlayerListener;
use hoyinm14mc\jail\listeners\sign\BlockListener as SignBlockListener;
use hoyinm14mc\jail\commands\JailCommand;
use hoyinm14mc\jail\commands\UnjailCommand;
use hoyinm14mc\jail\commands\SetjailCommand;
use hoyinm14mc\jail\commands\DeljailCommand;
use hoyinm14mc\jail\commands\JailedCommand;
use hoyinm14mc\jail\commands\JailsCommand;
use hoyinm14mc\jail\commands\JailtpCommand;
use hoyinm14mc\jail\commands\BailCommand;
use hoyinm14mc\jail\tasks\Timer;
use hoyinm14mc\jail\tasks\TipBroadcaster;
use hoyinm14mc\jail\tasks\UpdateCheckingTask;
use hoyinm14mc\jail\events\PlayerJailEvent;
use hoyinm14mc\jail\events\PlayerUnjailEvent;
use hoyinm14mc\jail\events\DeljailEvent;
use hoyinm14mc\jail\events\SetjailEvent;
use hoyinm14mc\jail\events\PlayerTeleportToJailEvent;
use hoyinm14mc\jail\UpdateChecker;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\level\Level;

class Jail extends PluginBase{

	private static $instance = null;

	const VERSION_STRING = "0.3-alpha";
	
	private $eco = null;

	public function onEnable(){
	    $this->getLogger()->info("Loading configurations..");
		if(! is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		$this->saveDefaultConfig();
		if($this->getConfig()->get("v") != $this::VERSION_STRING){
			unlink($this->getDataFolder() . "config.yml");
			$this->saveDefaultConfig();
		}
		$this->reloadConfig();
		$this->data = new Config($this->getDataFolder() . "players.yml", Config::YAML, array());
		$this->data2 = new Config($this->getDataFolder() . "jails.yml", Config::YAML, array());
		$this::$instance = $this;
		$this->getLogger()->info("Checking for update..");
		try{
			$updatechecker = new UpdateChecker($this, $this->getConfig()->get("default-channel"));
			$updatechecker->checkUpdate();
		} catch(Exception $e){
			echo "Unable to check update! Error: $e";
		}
		$this->getLogger()->info("Loading economy plugins..");
		$plugins = ["EconomyAPI", "PocketMoney", "MassiveEconomy"];
		foreach($plugins as $plugin_name){
		    $plugin = $this->getServer()->getPluginManager()->getPlugin($plugin_name);
		    if($plugin !== null && $this->eco === null){
		        $this->eco = $plugin;
		        $this->getLogger()->info("Loaded with ".$plugin_name."!");
		    }
		}
		if($this->eco === null){
		    $this->getLogger()->info("No economy plugin found!");
		}
		$this->getLogger()->info("Loading plugin..");
		$this->getCommand("jail")->setExecutor(new JailCommand($this));
		$this->getCommand("unjail")->setExecutor(new UnjailCommand($this));
		$this->getCommand("setjail")->setExecutor(new SetjailCommand($this));
		$this->getCommand("deljail")->setExecutor(new DeljailCommand($this));
		$this->getCommand("jailed")->setExecutor(new JailedCommand($this));
		$this->getCommand("jails")->setExecutor(new JailsCommand($this));
		$this->getCommand("jailtp")->setExecutor(new JailtpCommand($this));
		$this->getCommand("bail")->setExecutor(new BailCommand($this));
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new BlockListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new EntityListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new SignPlayerListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new SignBlockListener($this), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Timer($this), 20);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TipBroadcaster($this), 10);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new UpdateCheckingTask($this), $this->getConfig()->get("check-update-time") * 1200);
		$this->getLogger()->info($this->colourMessage("&aLoaded Successfully!"));
	}

	public function colourMessage($msg){
		return str_replace("&", "§", $msg);
	}

	public static function getInstance(){
		return $this::$instance;
	}
	
	public function getEco(){
	    return $this->eco;
	}

	public function hasPlayedBefore(Player $player){
		$t = $this->data->getAll();
		return (bool) isset($t[$player->getName()]);
	}

	/**
	 *
	 * @param Player $player        	
	 * @return boolean
	 */
	public function isJailed(Player $player){
		$t = $this->data->getAll();
		return (bool) $t[$player->getName()]["jailed"];
	}

	/**
	 *
	 * @param Player $player        	
	 * @param string $jail        	
	 * @param int $minutes        	
	 * @param string $reason        	
	 * @return boolean
	 */
	public function jail(Player $player, $jail, $minutes, $reason = "no reason"){
		$this->getServer()->getPluginManager()->callEvent($event = new PlayerJailEvent($this, $player, $jail, $minutes, $reason));
		if($event->isCancelled()){
			return false;
		}
		$t = $this->data->getAll();
		$j = $this->data2->getAll();
		if($this->isJailed($player) !== false){
			return false;
		}
		if($this->jailExists($jail) !== true){
			return false;
		}
		$x = $j[$jail]["x"];
		$y = $j[$jail]["y"];
		$z = $j[$jail]["z"];
		$world = $this->getServer()->getLevelByName($j[$jail]["world"]);
		$player->teleport(new Position($x, $y, $z, $world));
		$t[$player->getName()]["jailed"] = true;
		$t[$player->getName()]["jail"] = $jail;
		$t[$player->getName()]["minutes"] = round($minutes);
		$t[$player->getName()]["seconds"] = 0;
		$t[$player->getName()]["reason"] = $reason;
		$this->data->setAll($t);
		$this->data->save();
		return true;
	}

	/**
	 *
	 * @param Player $player        	
	 * @return boolean
	 */
	public function unjail(Player $player){
		$this->getServer()->getPluginManager()->callEvent($event = new PlayerUnjailEvent($this, $player));
		if($event->isCancelled()){
			return false;
		}
		$t = $this->data->getAll();
		if($this->isJailed($player) !== true){
			return false;
		}
		unset($t[$player->getName()]["jail"]);
		unset($t[$player->getName()]["minutes"]);
		unset($t[$player->getName()]["seconds"]);
		unset($t[$player->getName()]["reason"]);
		$t[$player->getName()]["jailed"] = false;
		$this->data->setAll($t);
		$this->data->save();
		$player->teleport($player->getLevel()->getSpawn());
		return true;
	}

	/**
	 *
	 * @param string $jail        	
	 * @param int $x        	
	 * @param int $y        	
	 * @param int $z        	
	 * @param Level $world        	
	 * @return boolean
	 */
	public function setJail($jail, $x, $y, $z, $world){
		$this->getServer()->getPluginManager()->callEvent($event = new SetjailEvent($this, $jail, new Position($x, $y, $z, $world)));
		if($event->isCancelled()){
			return false;
		}
		$j = $this->data2->getAll();
		if(isset($j[$jail])){
			return false;
		}
		$j[$jail]["x"] = $x;
		$j[$jail]["y"] = $y;
		$j[$jail]["z"] = $z;
		$j[$jail]["world"] = $world->getName();
		$this->data2->setAll($j);
		$this->data2->save();
		return true;
	}

	/**
	 *
	 * @param string $jail        	
	 * @return boolean
	 */
	public function delJail($jail){
		$this->getServer()->getPluginManager()->callEvent($event = new DeljailEvent($this, $jail));
		if($event->isCancelled()){
			return false;
		}
		$j = $this->data2->getAll();
		if(! isset($j[$jail])){
			return false;
		}
		unset($j[$jail]);
		$this->data2->setAll($j);
		$this->data2->save();
		return true;
	}

	/**
	 *
	 * @param string $jail        	
	 * @return boolean
	 */
	public function jailExists($jail){
		return $this->data2->exists($jail);
	}

	/**
	 *
	 * @param string $type        	
	 * @return multitype:string
	 */
	public function getJailedPlayers($type = "array"){
		$t = $this->data->getAll();
		if($type = "array"){
			$array = [];
			foreach(array_keys($t) as $name){
				if($t[$name]["jailed"] !== false){
					$array[$name] = $name;
				}
			}
			return $array;
		}
	}

	/**
	 *
	 * @return multitype:keys
	 */
	public function getJails(){
		$j = $this->data2->getAll();
		return array_keys($j);
	}

	/**
	 *
	 * @param Player $player        	
	 * @param string $jail        	
	 * @return boolean
	 */
	public function teleportToJail(Player $player, $jail){
		$this->getServer()->getPluginManager()->callEvent($event = new PlayerTeleportToJailEvent($this, $player, $jail));
		if($event->isCancelled()){
			return false;
		}
		$t = $this->data2->getAll();
		$x = $t[$jail]["x"];
		$y = $t[$jail]["y"];
		$z = $t[$jail]["z"];
		$world = $this->getServer()->getLevelByName($t[$jail]["world"]);
		$player->teleport(new Position($x, $y, $z, $world));
		return true;
	}

	/**
	 *
	 * @param Player $player        	
	 * @param integer $minutes        	
	 * @return boolean
	 */
	public function punish(Player $player, $minutes = 15){
		$t = $this->data->getAll();
		$t[$player->getName()]["minutes"] = $t[$player->getName()]["minutes"] + (int) $minutes;
		$this->data->setAll($t);
		$this->data->save();
		return true;
	}

}
?>