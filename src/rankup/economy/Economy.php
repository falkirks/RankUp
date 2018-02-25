<?php

namespace rankup\economy;

use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

class Economy extends BaseEconomy
{
    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function give($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return ($this->getAPI()->addMoney($player, $amt) === 1);
    }

    /**
     * @return Plugin
     */
    public function getAPI()
    {
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function take($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return ($this->getAPI()->reduceMoney($player, $amt) === 1);
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function setBal($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return ($this->getAPI()->setMoney($player, $amt) === 1);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function getBal(Player $player)
    {
        if (!$this->checkReady()) return false;
        //TODO there is probably a better way to do this
        $money = $this->getAPI()->getAllMoney();
        if (isset($money["money"][strtolower($player->getName())])) {
            return $money["money"][strtolower($player->getName())];
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return ($this->getAPI() instanceof PluginBase);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "EconomyS by onebone";
    }
}
