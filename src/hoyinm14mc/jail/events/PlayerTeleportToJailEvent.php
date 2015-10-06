<?php

namespace hoyinm14mc\jail\events;

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\bases\BaseEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerTeleportToJailEvent extends BaseEvent implements Cancellable{
    
    public static $handlerList = null;
    
    public $plugin;
    
    private $player;
    
    private $jail;
    
    public function __construct(Jail $plugin, Player $player, $jail){
        $this->plugin = $plugin;
        $this->player = $player;
        $this->jail = $jail;
        parent::__construct($plugin);
    }
    
    public function getPlayer(){
        return $this->player;
    }
    
    public function getJail(){
        return $this->jail;
    }
    
}
?>