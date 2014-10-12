<?php
namespace rankup\doesgroups;

use pocketmine\permission\Permissible;
use pocketmine\permission\Permission;
use pocketmine\Server;
use pocketmine\utils\Config;

class RankUpDoesGroups{
    /** @var \pocketmine\utils\Config  */
    private $config;
    /** @var \pocketmine\permission\Permission  */
    private $groupPermission;
    /** @var \pocketmine\Server  */
    private $server;
    /** @var  Group[] */
    private $groups;
    public function  __construct(Config $config, Permission $groupPermission, Server $server){
        $this->config = $config;
        $this->groupPermission = $groupPermission;
        $this->server = $server;
        $this->groups = [];
        $this->initPermissions();
    }
    public function setPlayerGroup(Permissible $player, $group){
        if(isset($this->groups[$group])){
            $this->removeGroups($player);
            $this->groups[$group]->addMember($player);
            return true;
        }
        else{
            return false;
        }
    }

    public function getPlayerGroup(Permissible $player){
        foreach($this->groups as $name => $group){
            if($group->isMember($player)){
                return $name;
            }
        }
        return false;
    }

    public function getGroup($name){
        return (isset($this->groups[$name]) ? $this->groups[$name] : false);
    }
    public function removeGroups(Permissible $permissible){
        foreach($this->groups as $group){
            if($group->isMember($permissible)){
                $group->removeMember($permissible);
            }
        }
    }

    public function initPermissions(){
        foreach($this->config->get('groups') as $name => $groupData){
            $perm = new Permission($this->getGroupPermission()->getName() . ".$name", "Apply $name kit");
            $perm->addParent($this->getGroupPermission(), true);
            $this->getServer()->getPluginManager()->addPermission($perm);
            $perms = [];
            foreach($groupData['perms'] as $str){
                $str = $this->getServer()->getPluginManager()->getPermission($str);
                if($str instanceof Permission){
                    $perms[] = $str;
                }
            }
            $this->groups[$name] = new Group($this, $perm, $perms, $groupData['entrance'], $groupData['exit']);
        }
    }
    /**
     * @return \pocketmine\utils\Config
     */
    public function getConfig(){
        return $this->config;
    }

    /**
     * @return \pocketmine\permission\Permission
     */
    public function getGroupPermission(){
        return $this->groupPermission;
    }

    /**
     * @return \pocketmine\Server
     */
    public function getServer(){
        return $this->server;
    }
}