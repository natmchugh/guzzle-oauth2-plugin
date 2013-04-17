<?php

namespace Fishtrap\Guzzle\Plugin;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OAuth2Plugin implements EventSubscriberInterface 
{

    public function __construct($config)
    {
        $this->config = Collection::fromConfig($config, array(
            'version' => '2.0',
            'consumer_key' => 'anonymous',
            'consumer_secret' => 'anonymous',
        ), array(
            'consumer_key', 'consumer_secret', 'version',
        ));
    }

   /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('client.create_request' => 'onRequestCreate');
    }

   /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     * @return string
     */
    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];

        $token = $this->config['token'];

        $request->setHeader(
            'Authorization',
            $this->buildAuthorizationHeader($token)
        );

        return $token;
    }

    /**
     * Builds the Authorization header for a request
     *
     * @param string $token the Oauth token
     *
     * @return string
     */
    private function buildAuthorizationHeader($token)
    {
        return sprintf('OAuth %s', $token);
    }
}