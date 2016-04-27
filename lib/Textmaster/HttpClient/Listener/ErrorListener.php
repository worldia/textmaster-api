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
use Textmaster\Exception\ErrorException;
use Textmaster\HttpClient\Message\ResponseMediator;

class ErrorListener
{
    /**
     * @var array
     */
    private $options;

    /**
     * ErrorListener constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function onRequestError(Event $event)
    {
        /** @var $request \Guzzle\Http\Message\Request */
        $request = $event['request'];
        $response = $request->getResponse();

        if ($response->isClientError() || $response->isServerError()) {
            $content = ResponseMediator::getContent($response);
            $message = isset($content['errors']) ? serialize($content['errors']) : serialize($content);

            throw new ErrorException($message, $response->getStatusCode());
        };
    }
}
