<?php

namespace rankup\economy;

use pocketmine\Player;
use rankup\RankUp;

abstract class BaseEconomy
{
    private $plugin;

    /**
     * BaseEconomy constructor.
     * @param RankUp $main
     */
    public function __construct(RankUp $main)
    {
        $this->plugin = $main;
    }

    /**
     * @param $amt
     * @param Player $player
     * @return mixed
     */
    public abstract function give($amt, Player $player);

    /**
     * @param $amt
     * @param Player $player
     * @return mixed
     */
    public abstract function take($amt, Player $player);

    /**
     * @param $amt
     * @param Player $player
     * @return mixed
     */
    public abstract function setBal($amt, Player $player);

    /**
     * @param Player $player
     * @return mixed
     */
    public abstract function getBal(Player $player);

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
    public function checkReady(): bool
    {
        if (!$this->isReady()) {
            $this->getPlugin()->reportEconomyLinkError();
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
