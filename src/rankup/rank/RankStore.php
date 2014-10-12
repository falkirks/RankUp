<?php
namespace rankup\rank;

use rankup\RankUp;

class RankStore{
    /** @var  Rank[] */
    private $ranks;
    /** @var  RankUp */
    private $main;
    public function __construct(RankUp $main){
        $this->main = $main;
    }

    public function loadFromConfig(){
        $this->ranks = [];
        foreach($this->getMain()->getConfig()->get('ranks') as $name => $price){
            $this->ranks[] = new Rank($name, $price, count($this->ranks));
        }
        $this->getMain()->getLogger()->info("Loaded " . count($this->ranks) . " ranks.");
    }

    /**
     * @return \rankup\RankUp
     */
    public function getMain(){
        return $this->main;
    }
}