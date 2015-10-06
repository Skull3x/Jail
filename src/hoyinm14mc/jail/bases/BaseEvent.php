<?php

namespace hoyinm14mc\jail\bases;

use hoyinm14mc\jail\Jail;
use pocketmine\event\plugin\PluginEvent;

abstract class BaseEvent extends PluginEvent{
    
    protected $plugin;
    
    public function __construct(Jail $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }
    
}
?>