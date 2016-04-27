<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api\User;

use Textmaster\Api\AbstractApi;
use Textmaster\Exception\InvalidArgumentException;

/**
 * Callbacks Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Callback extends AbstractApi
{
    /**
     * Set a callback url and format for a given user and event.
     *
     * @link https://fr.textmaster.com/documentation#users-update-callback-information
     * @deprecated Xml format is deprecated in favour of Json.
     *
     * @param string $userId Current user id
     * @param string $event  One of 'waiting_assignment', 'completed'
     * @param string $url    Callback Url
     * @param string $url    Desired callback format
     *
     * @return array
     */
    public function set($userId, $event, $url, $format)
    {
        if (!in_array($event, array('waiting_assignment', 'completed'), true)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid callback event.', $event));
        }

        if (!in_array($format, array('json', 'xml'), true)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid callback format.', $format));
        }

        return $this->put('clients/users/'.rawurlencode($userId), array(
            'user' => array(
                'callback' => array(
                    $event => array(
                        'url' => $url,
                        'format' => $format,
                    ),
                ),
            ),
        ));
    }
}
