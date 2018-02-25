<?php

namespace rankup;

use pocketmine\utils\Config;

class LanguageConfig
{
    private $lang;

    /**
     * LanguageConfig constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->lang = $config->get('lang');
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getLangSetting($name)
    {
        return $this->lang[$name];
    }
}
