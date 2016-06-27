<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\HttpClient\Message;

use GuzzleHttp\Psr7\Response;

class ResponseMediator
{
    /**
     * Get response content.
     *
     * @param Response $response
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     *
     * @throws \LogicException
     */
    public static function getContent(Response $response)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 300) {
            self::createException($response);
        }

        $body = $response->getBody();

        if ($response->hasHeader('Content-Type')
            && strpos($response->getHeader('Content-Type')[0], 'application/json') === 0
        ) {
            $content = json_decode($body->getContents(), true);
            if (array_key_exists('errors', $content)) {
                self::createException($response);
            }

            return $content;
        }

        return $body;
    }

    /**
     * @param Response $response
     *
     * @throws \LogicException
     */
    protected static function createException(Response $response)
    {
        $content = json_decode($response->getBody()->getContents(), true);
        if (array_key_exists('errors', $content)) {
            $message = json_encode($content['errors'], JSON_UNESCAPED_UNICODE);
        } else {
            $message = $response->getReasonPhrase();
        }
        throw new \LogicException($message, $response->getStatusCode());
    }
}
