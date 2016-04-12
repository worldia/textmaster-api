<?php

namespace Textmaster\HttpClient\Listener;

use Textmaster\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Textmaster\Exception\ErrorException;

class ErrorListener
{
    /**
     * @var array
     */
    private $options;

    /**
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

            throw new ErrorException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        };
    }
}
