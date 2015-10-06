<?php

namespace hoyinm14mc\jail\events;

use hoyinm14mc\jail\Jail;
use hoyinm14mc\jail\bases\BaseEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerUnjailEvent extends BaseEvent implements Cancellable{
    
    public static $handlerList = null;
    
    public $plugin;
    
    private $player;
    
    public function __construct(Jail $plugin, Player $player){
        $this->plugin = $plugin;
        $this->player = $player;
        parent::__construct($plugin);
    }
    
    public function getPlayer(){
        return $this->player;
    }
    
}
?>