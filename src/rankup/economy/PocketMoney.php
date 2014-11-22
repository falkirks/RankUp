<?php
namespace rankup\economy;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PocketMoney extends BaseEconomy{
    public function give($amt, Player $player){
        if(!$this->checkReady()) return false;
        return (!isset($this->getAPI()->grantMoney($player->getName(), $amt)->description));
    }
    public function take($amt, Player $player){
        if(!$this->checkReady()) return false;
        return (!isset($this->getAPI()->grantMoney($player->getName(), -$amt)->description));
    }
    public function setBal($amt, Player $player){
        if(!$this->checkReady()) return false;
        return (!isset($this->getAPI()->setMoney($player->getName(), $amt)->description));
    }
    public function getBal(Player $player){
        // TODO: Implement getBal() method.
        return 0;
    }
    public function getAPI(){
        return $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PocketMoney");
    }
    public function isReady(){
        return ($this->getAPI() instanceof PluginBase);
    }
    public function getName(){
        return "PocketMoney by MinecrafterJPN";
    }
}