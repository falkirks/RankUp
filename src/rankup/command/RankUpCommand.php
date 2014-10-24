<?php
namespace rankup\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use rankup\RankUp;

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
                //$sender->sendMessage($nextRank->getName());
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
                                $sender->sendMessage("You need " . ($nextRank->getPrice() - $this->getPlugin()->getEconomy()->getBal($sender)) . " to rank up.");
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
            $sender->sendMessage("Cool stats and details go here :-)");
        }
    }
    public function getPlugin(){
        return $this->main;
    }
}
