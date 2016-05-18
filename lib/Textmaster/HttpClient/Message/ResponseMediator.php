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
use Textmaster\Exception\ErrorException;

class ResponseMediator
{
    /**
     * Get response content.
     *
     * @param Response $response
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     *
     * @throws ErrorException
     */
    public static function getContent(Response $response)
    {
        $body = $response->getBody();
        if ($response->hasHeader('Content-Type') && strpos($response->getHeader('Content-Type')[0], 'application/json') === 0) {
            $content = json_decode($body->getContents(), true);
            if ($content['errors']) {
                throw new ErrorException(serialize($content['errors']), $response->getStatusCode());
            }

            return $content;
        }

        return $body;
    }
}
