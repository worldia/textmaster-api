<?php

namespace Textmaster\HttpClient\Listener;

use Guzzle\Common\Event;

class AuthListener
{
    private $key;
    private $secret;
    private $date;

    public function __construct($key, $secret, \DateTime $date = null)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->date = new \DateTime();

        if ($date) {
            $this->date = $date;
        }
    }

    public function onRequestBeforeSend(Event $event)
    {
        $event['request']->setHeader('APIKEY', $this->key);
        $event['request']->setHeader('DATE', $this->date->format('Y-m-d H:i:s'));
        $event['request']->setHeader('SIGNATURE', sha1($this->secret.$this->date->format('Y-m-d H:i:s')));
    }
}
