<?php

namespace rankup\doesgroups;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;

class Group
{
    /** @var \rankup\doesgroups\RankUpDoesGroups */
    private $main;
    /** @var \pocketmine\permission\Permission */
    private $perm;
    /** @var Permission[] */
    private $permsToSet;
    private $entrance;
    private $exit;
    private $name;
    private $members;

    private $attachmentMap;

    /**
     * Group constructor.
     * @param RankUpDoesGroups $main
     * @param $name
     * @param $perms
     * @param $entrance
     * @param $exit
     * @param $members
     */
    public function __construct(RankUpDoesGroups $main, $name, $perms, $entrance, $exit, $members)
    {
        $this->main = $main;
        $this->name = $name;
        $this->permsToSet = $perms;
        $this->entrance = $entrance;
        $this->exit = $exit;
        $this->members = $members;

        $this->attachmentMap = [];
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Performs required actions to add $play to this group and persist
     * @param Player $player
     */
    public function addMember(Player $player)
    {
        $this->members[] = $player->getName();
        $this->getMain()->saveMembers();

        $this->maintainMember($player);

        //$player->removeAttachment($attachment);
        foreach ($this->entrance as $cmd) {
            $this->getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{name}", $player->getName(), $cmd));
        }
    }


    /**
     * Performs duties for membership maintenance; attaching permissions
     * if player is not in group this is a noop
     * @param Player $player
     */
    public function maintainMember(Player $player){
        if(!isset($this->attachmentMap[$player->getName()]) && $this->isMember($player)) {
            $attachment = $player->addAttachment($this->getMain()->getServer()->getPluginManager()->getPlugin(RankUpDoesGroups::PARENT_PLUGIN_NAME));
            foreach ($this->permsToSet as $permToSet) {
                $attachment->setPermission($permToSet, true);
            }
            $this->attachmentMap[$player->getName()] = $attachment;
        }
    }

    /**
     * @return \rankup\doesgroups\RankUpDoesGroups
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function removeMember(Player $player)
    {
        if (in_array($player->getName(), $this->members)) {

            // Remove for register
            unset($this->members[array_search($player->getName(), $this->members)]);
            $this->getMain()->saveMembers();


            // Remove attachment if needed
            if(isset($this->attachmentMap[$player->getName()])){
                $player->removeAttachment($this->attachmentMap[$player->getName()]);
                unset($this->attachmentMap[$player->getName()]);
            }

            // Run exit commands
            foreach ($this->exit as $cmd) {
                $this->getMain()->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{name}", $player->getName(), $cmd));
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isMember(Player $player)
    {
        return in_array($player->getName(), $this->members);
    }
    
    /**
     * @return mixed
     */
    public function getEntrance()
    {
        return $this->entrance;
    }

    /**
     * @return mixed
     */
    public function getExit()
    {
        return $this->exit;
    }

    /**
     * @return \pocketmine\permission\Permission
     */
    public function getPerm()
    {
        return $this->perm;
    }

    /**
     * @return \pocketmine\permission\Permission[]
     */
    public function getPermsToSet()
    {
        return $this->permsToSet;
    }

}
