<?php

namespace Textmaster\HttpClient\Listener;

use Textmaster\Exception\TwoFactorAuthenticationRequiredException;
use Textmaster\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Textmaster\Exception\ApiLimitExceedException;
use Textmaster\Exception\ErrorException;
use Textmaster\Exception\RuntimeException;
use Textmaster\Exception\ValidationFailedException;

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
     * {@inheritDoc}
     */
    public function onRequestError(Event $event)
    {
        /** @var $request \Guzzle\Http\Message\Request */
        $request = $event['request'];
        $response = $request->getResponse();

        if ($response->isClientError() || $response->isServerError()) {
            $content = ResponseMediator::getContent($response);
            if (is_array($content) && isset($content['message'])) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content['message'], 400);
                }
            }

            throw new RuntimeException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        };
    }
}
