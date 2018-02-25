<?php

namespace rankup\permission;

use pocketmine\Player;

class RankUpDoesGroups extends BasePermissionManager
{
    /**
     * @param Player $player
     * @param $group
     * @return bool
     */
    public function addToGroup(Player $player, $group)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->setPlayerGroup($player, $group);
    }

    /**
     * @return \rankup\doesgroups\RankUpDoesGroups
     */
    public function getAPI()
    {
        return $this->getPlugin()->getRankUpDoesGroups();
    }

    /**
     * @param Player $player
     * @return bool|int|string
     */
    public function getGroup(Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->getPlayerGroup($player);
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function getPlayersInGroup($name)
    {
        if (!$this->checkReady()) return false;
        //TODO limit to players
        return $this->getAPI()->getGroup($name)->getMembers();
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->getPlugin()->isDoesGroupsLoaded();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "RankUpDoesGroups by Falk";
    }
}
