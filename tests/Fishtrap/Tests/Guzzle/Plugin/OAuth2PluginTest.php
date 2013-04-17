<?php
namespace Fishtrap\Tests\Guzzle\Plugin;

use Fishtrap\Guzzle\Plugin\OAuth2Plugin;
use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestFactory;
use Fishtrap\Guzzle\Plugin\AccessToken\BearerToken;

class OAuth2PluginTest extends \PHPUnit_Framework_TestCase
{

    protected function getRequest()
    {
        return RequestFactory::getInstance()->create('POST', 'http://www.test.com/path?a=b&c=d', null, array(
            'e' => 'f'
        ));
    }

    public function testConstructor()
    {
        $config = array(
            'client_identifier' => 'batman',
            'client_secret' => 'its-bruce-wayne',
        );
        $plugin = new OAuth2Plugin($config);
        $this->assertInstanceOf(
            'Fishtrap\Guzzle\Plugin\OAuth2Plugin',
            $plugin
        );
    }

    public function testSignsOauthRequests()
    {
        $plugin = new Oauth2Plugin(array('token' => 'nanana'));
        $event = new Event(array(
            'request' => $this->getRequest(),
        ));
        $params = $plugin->onRequestBeforeSend($event);

        $this->assertTrue($event['request']->hasHeader('Authorization'));

        $this->assertEquals(
            'OAuth nanana',
            (string) $event['request']->getHeader('Authorization')
        );
    }

    public function testSignsOauthRequestsBearerType()
    {
        $token = new BearerToken('nanana');
        $plugin = new Oauth2Plugin(array('token' => $token));
        $event = new Event(array(
            'request' => $this->getRequest(),
        ));
        $params = $plugin->onRequestBeforeSend($event);

        $this->assertTrue($event['request']->hasHeader('Authorization'));

        $this->assertEquals(
            'OAuth Bearer nanana',
            (string) $event['request']->getHeader('Authorization')
        );
    }
}