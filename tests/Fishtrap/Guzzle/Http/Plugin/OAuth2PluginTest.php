<?php
namespace Fishtrap\Guzzle\Http\Plugin;

use Guzzle\Http\Plugin\BasicAuthPlugin;
use Guzzle\Http\Client;

class OAuth2PluginTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $plugin = new OAuth2Plugin();
        $this->assertInstanceOf('Fishtrap\Guzzle\Http\Plugin\OAuth2Plugin', $plugin);
    }
}