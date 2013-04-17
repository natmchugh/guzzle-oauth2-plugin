<?php
namespace Fishtrap\Tests\Guzzle\Plugin;

use Fishtrap\Guzzle\Plugin\OAuth2Plugin;
use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestFactory;
use Fishtrap\Guzzle\Plugin\AccessToken\BearerToken;
use Fishtrap\Guzzle\Plugin\AccessToken\MacToken;

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
        $plugin = new Oauth2Plugin(array('token' => 'nanana', 'token_label' => 'OAuth'));
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
            'Bearer nanana',
            (string) $event['request']->getHeader('Authorization')
        );
    }

    public function testSignsOauthRequestsMacType()
    {
        $params = array(
            'id' => 'h480djs93hd8',
            'nonce' => '274312:dj83hs9s',
            'mac' => 'kDZvddkndxvhGRXZhvuDjEWhGeE=',
        );
        $token = new MacToken($params);
        $plugin = new Oauth2Plugin(array('token' => $token));
        $event = new Event(array(
            'request' => $this->getRequest(),
        ));
        $params = $plugin->onRequestBeforeSend($event);

        $this->assertTrue($event['request']->hasHeader('Authorization'));

        $this->assertEquals(
            'MAC id="h480djs93hd8",
nonce="274312:dj83hs9s",
mac="kDZvddkndxvhGRXZhvuDjEWhGeE="',
            (string) $event['request']->getHeader('Authorization')
        );
    }

   public function testDoesNotAddFalseyValuesToAuthorization()
    {
        unset($this->config['token']);
        $p = new Oauth2Plugin($this->config);
        $event = new Event(array('request' => $this->getRequest()));
        $p->onRequestBeforeSend($event);
        $this->assertTrue($event['request']->hasHeader('Authorization'));
        $this->assertNotContains('oauth_token=', (string) $event['request']->getHeader('Authorization'));
    }
}