<?php

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

            throw new ErrorException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        };
    }
}
