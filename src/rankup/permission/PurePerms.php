<?php
namespace rankup\permission;
use _64FF00\PurePerms\PPGroup;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PurePerms extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        if(!$this->checkReady()) return false;
        $ppGroup = $this->getAPI()->getGroup($group);
		$this->getAPI()->setGroup($player, $ppGroup);
        return true;
    }
    public function getGroup(Player $player){
        if(!$this->checkReady()) return false;		
		return $this->getAPI()->getUserDataMgr()->getGroup($player)->getName();
    }

    /**
     * getUsers() is not implemented in PurePerms. This method will NOT work.
     * @param $name
     * @return bool|void
     */
    public function getPlayersInGroup($name){
        if(!$this->checkReady()) return false;
        $ppGroup = $this->getAPI()->getGroup($name);
        if($ppGroup instanceof PPGroup) {
            return $this->getAPI()->getOnlinePlayersInGroup($ppGroup);
        }
        return null;
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
        return "PurePerms_v1.2 by 64FF00";
    }
}
