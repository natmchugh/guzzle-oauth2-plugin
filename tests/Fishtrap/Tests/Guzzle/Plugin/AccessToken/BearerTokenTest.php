<?php

namespace Fishtrap\Tests\Guzzle\Plugin\AccessToken;

use Fishtrap\Guzzle\Plugin\AccessToken\BearerToken;

class BearerTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {   
        $token = new BearerToken(array('access_token' => 'secret_access_token'));
        $this->assertSame('Bearer secret_access_token', (string) $token);
    }
}