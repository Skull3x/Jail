<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class JailtpCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "jailtp":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.jailtp") !== true){
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
                if(!$issuer instanceof Player){
                    $issuer->sendMessage($this->plugin->colourMessage("Command only works in-game!"));
                    return true;
                }
                $this->plugin->teleportToJail($issuer, $jail);
                $issuer->sendMessage($this->plugin->colourMessage("&6You have been teleported to jail &c".$jail));
                return true;
            break;
        }
    }
    
}
?>