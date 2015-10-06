<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class SetjailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "setjail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.setjail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(!isset($args[0])){
                    return false;
                }
                $jail = $args[0];
                if($this->plugin->jailExists($jail) !== false){
                    $issuer->sendMessage($this->plugin->colourMessage("&cJail already exists!"));
                    return true;
                }
                if(!$issuer instanceof Player){
                    $issuer->sendMessage($this->plugin->colourMessage("Command only works in-game!"));
                    return true;
                }
                $this->plugin->setJail($jail, $issuer->x, $issuer->y, $issuer->z, $issuer->getLevel());
                $issuer->sendMessage($this->plugin->colourMessage("&6You created jail: &c".$jail."&6!"));
                return true;
            break;
        }
    }
    
}
?>