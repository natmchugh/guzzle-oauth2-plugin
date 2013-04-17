<?php

namespace Fishtrap\Guzzle\Http\Plugin;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OAuth2Plugin implements EventSubscriberInterface 
{

   /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('client.create_request' => 'onRequestCreate');
    }
}