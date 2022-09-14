<?php

namespace rankup\rank;

use pocketmine\player\Player;
use rankup\RankUp;

class RankStore
{
    /** @var  Rank[] */
    private $ranks;
    /** @var  RankUp */
    private $main;

    /**
     * RankStore constructor.
     * @param RankUp $main
     */
    public function __construct(RankUp $main)
    {
        $this->main = $main;
    }

    /**
     *
     */
    public function loadFromConfig()
    {
        $this->ranks = [];
        foreach ($this->getMain()->getConfig()->get('ranks') as $name => $price) {
            $this->ranks[] = new Rank($name, count($this->ranks), $price);
        }
        $this->getMain()->getLogger()->info("Loaded " . count($this->ranks) . " ranks.");
    }

    /**
     * @return \rankup\RankUp
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param Player $player
     * @return bool|Rank
     */
    public function getNextRank(Player $player)
    {
        //TODO check if perm is linked
        $group = $this->getMain()->getPermManager()->getGroup($player);
        if ($group !== false) {
            $rank = $this->getRankByName($group);
            if ($rank !== false) {
                if ($rank->getOrder() == count($this->ranks) - 1) {
                    return false;
                } else {
                    return $this->ranks[$rank->getOrder() + 1];
                }
            } else {
                return $this->ranks[0];
            }
        } else {
            return $this->ranks[0];
        }
    }

    /**
     * @param $name
     * @return bool|Rank
     */
    public function getRankByName($name)
    {
        foreach ($this->ranks as $rank) {
            if (strtolower($rank->getName()) === strtolower($name)) {
                return $rank;
            }
        }
        return false;
    }
}
