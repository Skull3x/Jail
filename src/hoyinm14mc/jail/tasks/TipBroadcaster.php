<?php

namespace hoyinm14mc\jail\tasks;

use hoyinm14mc\jail\bases\BaseTask;
use pocketmine\scheduler\PluginTask;

class TipBroadcaster extends BaseTask{
    
    public function onRun($tick){
        $t = $this->plugin->data->getAll();
        foreach(array_keys($t) as $name){
            $player = $this->plugin->getServer()->getPlayer($name);
            if($player !== null && $this->plugin->isJailed($player) !== false){
                $player->sendTip($this->plugin->colourMessage("&cYou have been jailed!\n&r&6Time left: &e".($t[$name]["minutes"] < 10 ? "0" : "").$t[$name]["minutes"]."&b:&e".($t[$name]["seconds"] < 10 ? "0" : "").$t[$name]["seconds"]." &7mins:secs"));
            }
        }
    }
    
}
?>