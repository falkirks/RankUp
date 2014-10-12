<?php
namespace rankup\doesgroups;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\permission\Permissible;
use pocketmine\permission\Permission;
use pocketmine\Player;

class Group{
    /** @var \rankup\doesgroups\RankUpDoesGroups  */
    private $main;
    /** @var \pocketmine\permission\Permission  */
    private $perm;
    /** @var Permission[]  */
    private $permsToSet;
    private $entrance;
    private $exit;
    public function __construct(RankUpDoesGroups $main, Permission $perm, $perms, $entrance, $exit){
        $this->main = $main;
        $this->perm = $perm;
        $this->permsToSet = $perms;
        $this->entrance = $entrance;
        $this->exit = $exit;
        $this->initChildren();
    }
    /**
     * @return \pocketmine\permission\Permissible[]
     */
    public function getMembers(){
        return $this->getPerm()->getPermissibles();
    }
    public function addMember(Permissible $permissible){
        $attachment = $permissible->addAttachment($this->getMain()->getServer()->getPluginManager()->getPlugin("RankUp"));
        $attachment->setPermission($this->perm, true);
        $permissible->removeAttachment($attachment);
        if($permissible instanceof Player){
            foreach($this->entrance as $cmd){
                $this->getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{name}", $permissible->getName(), $cmd));
            }
        }
    }
    public function removeMember(Permissible $permissible){
        $attachment = $permissible->addAttachment($this->getMain()->getServer()->getPluginManager()->getPlugin("RankUp"));
        $attachment->unsetPermission($this->perm);
        $permissible->removeAttachment($attachment);
        if($permissible instanceof Player){
            foreach($this->exit as $cmd){
                $this->getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{name}", $permissible->getName(), $cmd));
            }
        }
    }
    public function isMember(Permissible $permissible){
        return $permissible->hasPermission($this->perm);
    }
    public function initChildren(){
        foreach($this->permsToSet as $permToChild){
            $permToChild->addParent($this->perm, true);
        }
    }
    /**
     * @return mixed
     */
    public function getEntrance(){
        return $this->entrance;
    }

    /**
     * @return mixed
     */
    public function getExit(){
        return $this->exit;
    }

    /**
     * @return \rankup\doesgroups\RankUpDoesGroups
     */
    public function getMain(){
        return $this->main;
    }

    /**
     * @return \pocketmine\permission\Permission
     */
    public function getPerm(){
        return $this->perm;
    }

    /**
     * @return \pocketmine\permission\Permission[]
     */
    public function getPermsToSet(){
        return $this->permsToSet;
    }

}