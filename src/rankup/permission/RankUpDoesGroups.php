<?php
namespace rankup\permission;
use pocketmine\Player;
use rankup\doesgroups\RankUpDoesGroups as DoesGroups;

class RankUpDoesGroups extends BasePermissionManager{
    public function addToGroup(Player $player, $group){
        // TODO: Implement addToGroup() method.
    }

    public function getGroup(Player $player){
        // TODO: Implement getGroup() method.
    }

    public function getAPI(){
        // TODO: Implement getAPI() method.
    }

    public function isReady(){
        // TODO: Implement isReady() method.
    }

    public function getName(){
        return "RankUpDoesGroups by Falk";
    }

}