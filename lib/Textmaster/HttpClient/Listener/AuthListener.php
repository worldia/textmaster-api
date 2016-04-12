<?php

namespace Textmaster\HttpClient\Listener;

use Guzzle\Common\Event;

class AuthListener
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * AuthListener constructor.
     *
     * @param string         $key
     * @param string         $secret
     * @param \DateTime|null $date
     */
    public function __construct($key, $secret, \DateTime $date = null)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->date = new \DateTime();

        if ($date) {
            $this->date = $date;
        }
    }

    /**
     * Add authentication headers to each request.
     *
     * @param Event $event
     */
    public function onRequestBeforeSend(Event $event)
    {
        $event['request']->setHeader('APIKEY', $this->key);
        $event['request']->setHeader('DATE', $this->date->format('Y-m-d H:i:s'));
        $event['request']->setHeader('SIGNATURE', sha1($this->secret.$this->date->format('Y-m-d H:i:s')));
    }
}
