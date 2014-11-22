<?php
namespace rankup\permission;

use _64FF00\xPermissions\data\Group;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class xPermissions extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        if(!$this->checkReady()) return false;
        foreach($this->getAPI()->getAllGroups() as $xpermsGroups) {
            if(strtolower($xpermsGroups->getName()) == strtolower($group)){
                $group = $xpermsGroups;
                break;
            }
        }
        if($group instanceof Group){
            $this->getAPI()->setGroup($player, $group, $this->getAPI()->getServer()->getDefaultLevel()->getName());
            return true;
        }
        return false;
    }

    public function getGroup(Player $player){
        if(!$this->checkReady()) return false;
        return $this->getAPI()->getUser($player->getName())->getUserGroup($this->getAPI()->getServer()->getDefaultLevel()->getName())->getName();
    }

    public function getPlayersInGroup($name){
        // TODO: Implement getPlayersInGroup() method.
    }

    /**
     * @return null|\_64FF00\xPermissions\xPermissions
     */
    public function getAPI(){
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("xPermissions");
    }

    public function isReady(){
        return ($this->getAPI() instanceof PluginBase);
    }

    public function getName(){
        return "xPermissions by _64FF00";
    }
}