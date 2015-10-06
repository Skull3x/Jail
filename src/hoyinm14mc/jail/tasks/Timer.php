<?php

namespace hoyinm14mc\jail\tasks;

use hoyinm14mc\jail\bases\BaseTask;
use pocketmine\scheduler\PluginTask;

class Timer extends BaseTask{
    
    public function onRun($tick){
        $t = $this->plugin->data->getAll();
        foreach(array_keys($t) as $name){
            if($t[$name]["jailed"] === true){
                $t[$name]["seconds"] = (int) $t[$name]["seconds"] - 1;
                $this->plugin->data->setAll($t);
                $this->plugin->data->save();
                if($t[$name]["seconds"] < 0){
                    $target = $this->plugin->getServer()->getPlayer($name);
                    if($t[$name]["minutes"] == 0 && $t[$name]["seconds"] < 0){
                        if($target !== null){
                            $this->plugin->unjail($target);
                            $target->sendMessage($this->plugin->colourMessage("&l&aTIME'S UP!\n&6You have been unjailed!")); 
                        }else{
                            $t[$name]["need-tp"] = true;
                            $t[$name]["jailed"] = false;
                            unset($t[$name]["jail"]);   
                            unset($t[$name]["minutes"]);
                            unset($t[$name]["seconds"]);
                            unset($t[$name]["reason"]);
                            $this->plugin->data->setAll($t);
                            $this->plugin->data->save();
                        }
                    }else{
                        $t[$name]["minutes"] = $t[$name]["minutes"] - 1;
                        $t[$name]["seconds"] = 59;
                        $this->plugin->data->setAll($t);
                        $this->plugin->data->save();
                    }
                }
            }       
        }
    }
    
}
?>