<?php

namespace hoyinm14mc\jail\events;

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\bases\BaseEvent;
use pocketmine\event\Cancellable;
use pocketmine\level\Position;

class DeljailEvent extends BaseEvent implements Cancellable{
    
    public static $handlerList = null;
    
    public $plugin;
    
    private $jail;
    
    public function __construct(Jail $plugin, $jail){
        $this->plugin = $plugin;
        $this->jail = $jail;
        parent::__construct($plugin);
    }
    
    public function getJail(){
        return $this->jail;
    }
    
}
?>