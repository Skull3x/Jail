<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class JailsCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "jails":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.jails") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                $issuer->sendMessage($this->plugin->colourMessage("&6Jails: &f".implode(", ", $this->plugin->getJails())));
                return true;
            break;
        }
    }
    
}
?>