<?php
namespace Fishtrap\Guzzle\Plugin\AccessToken;

class BearerToken implements TokenInterface
{
    private $label;

    public function __construct($tokenString, $label = 'Bearer')
    {
        $this->tokenString = $tokenString;
        $this->label = $label;
    }

    public function __toString()
    {
        return $this->tokenString;
    }

    public function getLabel()
    {
        return $this->label;
    }
}
