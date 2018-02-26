<?php

namespace rankup\doesgroups;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class RankUpDoesGroups implements Listener {
    /**
     * RankUpDoesGroups is an ideally plugin agnostic (bad) group manager
     * it needs to leech off a plugin to register events and permissions.
     *
     * But this could be any plugin...
     */
    const PARENT_PLUGIN_NAME = "RankUp";

    /** @var \pocketmine\utils\Config */
    private $config;
    /** @var \pocketmine\permission\Permission */
    private $groupPermission;
    /** @var \pocketmine\Server */
    private $server;
    /** @var  Group[] */
    private $groups;

    /**
     * RankUpDoesGroups constructor.
     * @param Config $config
     * @param Permission $groupPermission
     * @param Server $server
     */
    public function __construct(Config $config, Permission $groupPermission, Server $server)
    {
        $this->config = $config;
        $this->groupPermission = $groupPermission;
        $this->server = $server;
        $this->groups = [];
        $this->initPermissions();

        $this->getServer()->getPluginManager()->registerEvents($this, $server->getPluginManager()->getPlugin(self::PARENT_PLUGIN_NAME));
    }

    public function initPermissions()
    {
        foreach ($this->config->get('groups') as $name => $groupData) {
            $this->groups[$name] = new Group($this, $name, $groupData['perms'], $groupData['entrance'], $groupData['exit'], $groupData['members']);
        }
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function onPlayerJoin(PlayerJoinEvent $event){
        foreach ($this->groups as $group){
            $group->maintainMember($event->getPlayer());
        }
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param Player $player
     * @param $group
     * @return bool
     */
    public function setPlayerGroup(Player $player, $group)
    {
        if (isset($this->groups[$group])) {
            $this->removeGroups($player);
            $this->groups[$group]->addMember($player);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Player $player
     */
    public function removeGroups(Player $player)
    {
        foreach ($this->groups as $group) {
            if ($group->isMember($player)) {
                $group->removeMember($player);
            }
        }
    }

    /**
     * @param Player $player
     * @return bool|int|string
     */
    public function getPlayerGroup(Player $player)
    {
        foreach ($this->groups as $name => $group) {
            if ($group->isMember($player)) {
                return $name;
            }
        }
        return false;
    }


    /**
     * @param $name
     * @return bool|mixed|Group
     */
    #Do NOT use this function
    public function getGroup($name)
    {
        return (isset($this->groups[$name]) ? $this->groups[$name] : false);
    }

    public function saveMembers()
    {
        $arr = $this->getConfig()->getAll();
        foreach ($this->groups as $name => $group) {
            $arr['groups'][$name]['members'] = $group->getMembers();
        }
        $this->getConfig()->setAll($arr);
        $this->getConfig()->save();
    }

    /**
     * @return \pocketmine\utils\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \pocketmine\permission\Permission
     */
    public function getGroupPermission()
    {
        return $this->groupPermission;
    }
}
