<?php

namespace hoyinm14mc\jail\events;

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\bases\BaseEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerJailEvent extends BaseEvent implements Cancellable{
    
    public static $handlerList = null;
    
    public $plugin;
    
    private $player;
    
    private $jail;
    
    private $minutes;
    
    private $reason;
    
    public function __construct(Jail $plugin, Player $player, $jail, $minutes, $reason){
        $this->plugin = $plugin;
        $this->player = $player;
        $this->jail = $jail;
        $this->minutes = (int) $minutes;
        $this->reason = $reason;
        parent::__construct($plugin);
    }
    
    public function getJail(){
        return $this->jail;
    }
    
    public function getPlayer(){
        return $this->player;
    }
    
    public function getTime(){
        return $this->minutes;
    }
    
    public function getReason(){
        return $this->reason;
    }
    
}
?>