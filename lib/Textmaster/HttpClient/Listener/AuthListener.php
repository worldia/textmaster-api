<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
        $this->date = new \DateTime('now', new \DateTimeZone('UTC'));

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
