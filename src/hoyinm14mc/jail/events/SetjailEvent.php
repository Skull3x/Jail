<?php

namespace hoyinm14mc\jail\events;

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\bases\BaseEvent;
use pocketmine\event\Cancellable;
use pocketmine\level\Position;

class SetjailEvent extends BaseEvent implements Cancellable{
    
    public static $handlerList = null;
    
    public $plugin;
    
    private $jail;
    
    private $pos;
    
    public function __construct(Jail $plugin, $jail, Position $pos){
        $this->plugin = $plugin;
        $this->jail = $jail;
        $this->pos = $pos;
        parent::__construct($plugin);
    }
    
    public function getJail(){
        return $this->jail;
    }
    
    public function getPosition(){
        return $this->pos;
    }
    
}
?>