<?php

namespace hoyinm14mc\jail\bases;

use hoyinm14mc\jail\Jail;
use pocketmine\event\Listener;

abstract class BaseListener implements Listener{
    
    protected $plugin;
    
    public function __construct(Jail $plugin){
        $this->plugin = $plugin;
    }
    
    public function getPlugin(){
        return $this->plugin;
    }
}
?>