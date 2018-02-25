<?php

namespace rankup\permission;

use pocketmine\Player;
use rankup\RankUp;

abstract class BasePermissionManager
{
    private $plugin;

    /**
     * BasePermissionManager constructor.
     * @param RankUp $main
     */
    public function __construct(RankUp $main)
    {
        $this->plugin = $main;
    }

    /**
     * @param Player $player
     * @param $group
     * @return mixed
     */
    public abstract function addToGroup(Player $player, $group);

    /**
     * @param Player $player
     * @return mixed
     */
    public abstract function getGroup(Player $player);

    /**
     * @param $name
     * @return mixed
     */
    public abstract function getPlayersInGroup($name);

    /**
     * @return mixed
     */
    public abstract function getAPI();

    /**
     * @return mixed
     */
    public abstract function getName();

    /**
     * @return bool
     */
    public function checkReady()
    {
        if (!$this->isReady()) {
            $this->getPlugin()->reportPermissionLinkError();
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public abstract function isReady();

    /**
     * @return RankUp
     */
    public function getPlugin()
    {
        return $this->plugin;
    }
}
