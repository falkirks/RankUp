<?php

namespace rankup\economy;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PocketMoney extends BaseEconomy
{
    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function give($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->grantMoney($player->getName(), $amt);
    }

    /**
     * @return \PocketMoney\PocketMoney
     */
    public function getAPI()
    {
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PocketMoney");
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function take($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->grantMoney($player->getName(), -$amt);
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function setBal($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->setMoney($player->getName(), $amt);
    }

    /**
     * @param Player $player
     * @return mixed
     */
    public function getBal(Player $player)
    {
        return $this->getAPI()->getMoney($player->getName());
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
        return "PocketMoney by MinecrafterJPN";
    }
}
