<?php
namespace rankup\permission;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PurePerms extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        if(!$this->checkReady()) return false;
    }

    public function getGroup(Player $player){
        // TODO: Implement getGroup() method.
    }

    public function getPlayersInGroup($name){
        // TODO: Implement getPlayersInGroup() method.
    }

    /**
     * @return null|\_64FF00\PurePerms\PurePerms
     */
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