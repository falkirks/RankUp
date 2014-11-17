<?php
namespace rankup\permission;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PurePerms extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        // TODO: Implement addToGroup() method.
    }

    public function getGroup(Player $player){
        // TODO: Implement getGroup() method.
    }

    public function getPlayersInGroup($name){
        // TODO: Implement getPlayersInGroup() method.
    }

    public function getAPI(){
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PurePerms");
    }

    public function isReady(){
        return ($this->getAPI() instanceof PluginBase);
    }

    public function getName(){
        // TODO: Implement getName() method.
    }

}