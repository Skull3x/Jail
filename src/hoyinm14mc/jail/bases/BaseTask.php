<?php

namespace hoyinm14mc\jail\bases;

use hoyinm14mc\jail\Jail;
use pocketmine\scheduler\PluginTask;

abstract class BaseTask extends PluginTask{
    
    protected $plugin;
    
    public function __construct(Jail $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
    
}
?>