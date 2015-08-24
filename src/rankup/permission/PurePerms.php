<?php
namespace rankup\permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PurePerms extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        if(!$this->checkReady()) return false;
        $ppGroup = $this->getAPI()->getGroup($group);
		$this->getAPI()->getUser($player)->setGroup($ppGroup, null);
        return true;
    }
    public function getGroup(Player $player){
        if(!$this->checkReady()) return false;		
		$user = $this->getAPI()->getUser($player);
		return $user->getGroup()->getName();
    }

    /**
     * getUsers() is not implemented in PurePerms. This method will NOT work.
     * @param $name
     * @return bool|void
     */
    public function getPlayersInGroup($name){
        if(!$this->checkReady()) return false;
        $group = $this->getAPI()->getGroup($name);
        if($group !== null) {
            return $group->getUsers();
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
        return "PurePerms by 64FF00";
    }
}
