<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class UnjailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "unjail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.unjail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(!isset($args[0])){
                    return false;
                }
                $target = $this->plugin->getServer()->getPlayer($args[0]);
                if($target === null){
                    $issuer->sendMessage($this->plugin->colourMessage("&cInvalid target!"));
                    return true;
                }
                if($this->plugin->isJailed($target) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cTarget is not jailed!"));
                    return true;
                }
                $this->plugin->unjail($target);
                $issuer->sendMessage($this->plugin->colourMessage("&6You unjailed &e".$target->getName()." &6!"));
                $target->sendMessage($this->plugin->colourMessage("&6You have been unjailed!"));
                return true;
            break;
        }
    }
    
}
?>