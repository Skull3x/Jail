<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class JailedCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "jailed":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.jailed") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                $issuer->sendMessage($this->plugin->colourMessage("&e----------&bJailed Players&e----------"));
                $issuer->sendMessage($this->plugin->colourMessage("&6PLAYER &f: &6JAIL &f: &6REASON"));
                $t = $this->plugin->data->getAll();
                foreach($this->plugin->getJailedPlayers() as $name){
                    $issuer->sendMessage($name." : ".$t[$name]["jail"]." : ".$t[$name]["reason"]);
                }
                $issuer->sendMessage($this->plugin->colourMessage("§e--------------------------------"));
                return true;
            break;
        }
    }
    
}
?>