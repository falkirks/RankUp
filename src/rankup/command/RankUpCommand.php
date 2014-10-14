<?php
namespace rankup\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use rankup\RankUp;
use rankup\economy; //so economy money can be read

class RankUpCommand extends Command implements PluginIdentifiableCommand{
    private $main;
    public function __construct(RankUp $main){
        parent::__construct("rankup", "Get all the ranks.", "/rankup", ["ru"]);
        $this->main = $main;
    }
    public function execute(CommandSender $sender, $label, array $args){
        if($sender instanceof Player && count($args) == 0 || !$sender->hasPermission("rankup.admin")){
            if($sender->hasPermission("rankup.rankup")){
                $nextRank = $this->getPlugin()->getRankStore()->getNextRank($sender);
                $sender->sendMessage($nextRank->getName());
                if($nextRank !== false){
                    if($nextRank->getPrice() == 0 || $this->getPlugin()->isLinkedToEconomy()){
                        if($nextRank->getPrice() > 0){
                            if($this->getPlugin()->getEconomy()->take($nextRank->getPrice(), $sender) !== false){
                                if($this->getPlugin()->getPermManager()->addToGroup($sender, $nextRank->getName()) !== false){
                                    //TODO add to lang
                                    $sender->sendMessage("You have been ranked up to " . $nextRank->getName());
                                }
                                else{
                                    //TODO add to lang
                                    $sender->sendMessage("Failed to rankup. Refunded price.");
                                    $this->getPlugin()->getEconomy()->give($nextRank->getPrice(), $sender);
                                }
                            }
                            else{
                                //TODO add to lang and X/Y
                                $sender->sendMessage("Looks like you don't have enough money.");
                                $username = $sender->getName();
                                EconomyAPI::getInstance()->getAllMoney($username); //will get money from all users from EconomyAPI-onebone
                                $userMoney = EconomyAPI::getInstance()->userMoney($username); //gets users money
                                $sender->sendMessage("You need " . ($nextRank - $userMoney) . " to rank up."); //will send message on how much money until they rankup
                            }
                        }
                        else{
                            if($this->getPlugin()->getPermManager()->addToGroup($sender, $nextRank->getName()) !== false){
                                //TODO add to lang
                                $sender->sendMessage("You have been ranked up to " . $nextRank->getName());
                            }
                            else{
                                //TODO add to lang
                                $sender->sendMessage("Failed to rankup. Try again later.");
                            }
                        }
                    }
                    else{
                        //TODO add to lang
                        $sender->sendMessage("Can't purchase now.");
                    }
                 }
                else{
                    //TODO add to lang
                    $sender->sendMessage("You have the maximum rank.");
                }
            }
            else{
                $sender->sendMessage("You don't have permission to rankup.");
            }
        }
        else{

        }
    }
    public function getPlugin(){
        return $this->main;
    }
}
