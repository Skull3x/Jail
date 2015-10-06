<?php

namespace hoyinm14mc\jail\commands;

use hoyinm14mc\jail\bases\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class JailCommand extends BaseCommand{
    
    public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
        switch($cmd->getName()){
            case "jail":
                if($issuer->hasPermission("jail.command") !== true && $issuer->hasPermission("jail.command.jail") !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cYou don't have permission for this!"));
                    return true;
                }
                if(count($args) < 3){
                    return false;
                }
                $target = $this->plugin->getServer()->getPlayer($args[0]);
                if($target === null){
                    $issuer->sendMessage($this->plugin->colourMessage("&cInvalid target!"));
                    return true;
                }
                $jail = $args[1];
                if($this->plugin->jailExists($jail) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cJail doesn't exist!"));
                    return true;
                }
                if($this->plugin->isJailed($target) !== false){
                    $issuer->sendMessage($this->plugin->colourMessage("&cTarget is already jailed!"));
                    return true;
                }
                if(is_numeric($args[2]) !== true){
                    $issuer->sendMessage($this->plugin->colourMessage("&cInvalid time!"));
                    return true;
                }
                if(count($args) > 3){
                    $msg = $this->getMsg($args);
                    $this->plugin->jail($target, $jail, $args[2], $msg);
                    $issuer->sendMessage($this->plugin->colourMessage("&6You jailed &e".$target->getName()." &6into &c".$jail."&6 for&c ".$args[2]." &6minutes!\n&aReason: &f".$msg));
                    $target->sendMessage($this->plugin->colourMessage("&6You have been jailed into &c".$jail." &6for &c".$args[2]." &6minutes!\n&aReason: &f".$msg));
                }else{
                    $this->plugin->jail($target, $jail, $args[2]);
                    $issuer->sendMessage($this->plugin->colourMessage("&6You jailed &e".$target->getName()." &6into &c".$jail."&6 for&c ".$args[2]." &6minutes!"));
                    $target->sendMessage($this->plugin->colourMessage("&6You have been jailed into &c".$jail." &6for &c".$args[2]." &6minutes!"));
                }
                return true;
            break;
        }
    }
    
    public function getMsg($args){
        unset($args[0]);
        unset($args[1]);
        unset($args[2]);
        return implode(" ", $args);
    }
    
}
?>