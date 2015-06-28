<?php
namespace rankup\permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PurePerms extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        if(!$this->checkReady()) return false;
		foreach($this->getAPI()->getGroups() as $PPGroup){
			if(strtolower($PPGroup->getName()) == strtolower($group)){
				$group = $PPGroup;
				break;
			}
		}
    }
    public function getGroup(Player $player){
        if(!$this->checkReady()) return false;		
		$user = $this->getAPI()->getUser($player);
		return $user->getGroup()->getName();
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
        return "PurePerms by 64FF00";
    }
}
