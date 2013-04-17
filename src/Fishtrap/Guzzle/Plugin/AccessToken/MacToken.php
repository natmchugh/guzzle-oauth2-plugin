<?php

namespace Fishtrap\Guzzle\Plugin\AccessToken;

class MacToken implements TokenInterface
{
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getLabel()
    {
        return 'MAC';
    }

    public function __toString()
    {
        $macString = '';
        foreach ($this->config as $key => $value) {
            $macString .= sprintf('%s="%s",'.PHP_EOL, $key, $value);
        }
        return trim($macString, PHP_EOL.",");
    }
}
