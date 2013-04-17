<?php
namespace Fishtrap\Guzzle\Plugin\AccessToken;

class BearerToken
{
    public function __construct($tokenString)
    {
        $this->tokenString = $tokenString;
    }

    public function __toString()
    {
        return sprintf('Bearer %s', $this->tokenString);
    }
}