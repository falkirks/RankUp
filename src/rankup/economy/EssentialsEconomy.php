<?php

namespace rankup\economy;

use EssentialsPEconomy\EssentialsPEconomy;
use EssentialsPEconomy\Providers\BaseEconomyProvider;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class EssentialsEconomy extends BaseEconomy
{
    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function give($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->addToBalance($player, $amt);
    }

    /**
     * @return BaseEconomyProvider
     */
    public function getAPI()
    {
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("EssentialsPEconomy")->getProvider();
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function take($amt, Player $player)
    {
        if (!$this->checkReady()) return false;

        return $this->getAPI()->subtractFromBalance($player, $amt);
    }

    /**
     * @param $amt
     * @param Player $player
     * @return bool
     */
    public function setBal($amt, Player $player)
    {
        if (!$this->checkReady()) return false;
        return $this->getAPI()->setBalance($player, $amt);
    }

    /**
     * @param Player $player
     * @return mixed
     */
    public function getBal(Player $player)
    {
        return $this->getAPI()->getBalance($player);
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("EssentialsPEconomy") instanceof PluginBase;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "EssentialsPE by LegendsOfMCPE";
    }
}
