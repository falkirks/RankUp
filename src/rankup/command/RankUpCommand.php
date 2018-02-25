<?php

namespace rankup\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use rankup\RankUp;

class RankUpCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    /**
     * RankUpCommand constructor.
     * @param RankUp $main
     */
    public function __construct(RankUp $main)
    {
        parent::__construct("rankup", "Get all the ranks.", "/rankup", ["ru"]);
        $this->main = $main;
    }

    /**
     * @param CommandSender $sender
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $label, array $args): bool
    {
        if ($sender instanceof Player && count($args) == 0 || !$sender->hasPermission("rankup.admin")) {
            if ($sender->hasPermission("rankup.rankup")) {
                $nextRank = $this->main->getRankStore()->getNextRank($sender);
                //$sender->sendMessage($nextRank->getName());
                if ($nextRank !== false) {
                    if ($nextRank->getPrice() === 0 || $this->main->isLinkedToEconomy()) {
                        if ($nextRank->getPrice() > 0) {
                            if ($this->main->getEconomy()->take($nextRank->getPrice(), $sender) !== false) {
                                if ($this->main->getPermManager()->addToGroup($sender, $nextRank->getName()) !== false) {
                                    $sender->sendMessage(sprintf($this->main->getLanguageConfig()->getLangSetting('ranked-up-paid'), $nextRank->getName()));
                                } else {
                                    $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('group-add-error-paid'));
                                    $this->main->getEconomy()->give($nextRank->getPrice(), $sender);
                                }
                            } else {
                                $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('need-more-money-1'));
                                $sender->sendMessage(sprintf($this->main->getLanguageConfig()->getLangSetting('need-more-money-2'), $nextRank->getPrice() - $this->main->getEconomy()->getBal($sender)));
                            }
                        } else {
                            if ($this->main->getPermManager()->addToGroup($sender, $nextRank->getName()) !== false) {
                                $sender->sendMessage(sprintf($this->main->getLanguageConfig()->getLangSetting('ranked-up-free'), $nextRank->getName()));
                            } else {
                                $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('group-add-error-free'));
                            }
                        }
                    } else {
                        $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('missing-economy'));
                    }
                } else {
                    $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('have-max-rank'));
                }
            } else {
                $sender->sendMessage($this->main->getLanguageConfig()->getLangSetting('command-permission-error'));
            }
        } else {
            $sender->sendMessage("Cool stats and details go here :-)");
        }
        return true;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    /**
     * @return RankUp
     */
    public function getMain(): RankUp
    {
        return $this->main;
    }
}
