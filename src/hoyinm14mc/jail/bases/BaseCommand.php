<?php

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