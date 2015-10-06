<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class DeljailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "deljail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.deljail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(!isset($args[0])){
                    return false;
                }
                $jail = $args[0];
                if($this->plugin->jailExists($jail) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cJail doesn't exist!"));
                    return true;
                }
                $t = $this->plugin->data->getAll();
                $result = true;
                foreach(array_keys($t) as $name){
                    if(isset($t[$name]["jail"]) && $t[$name]["jail"] == $jail){
                        if($result !== false){
                            $result = false;
                        }
                    }
                }
                if($result !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cUnable to delete jail.  Someone is still being jailed there!"));
                    return true;
                }
                $this->plugin->delJail($jail);
                $issuer->sendMessage($this->plugin->colourMessage("&6You deleted jail: &c".$jail."&6!"));
                return true;
            break;
        }
    }
    
}
?>