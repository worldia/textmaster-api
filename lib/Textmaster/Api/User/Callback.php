<?php

namespace Textmaster\Api\User;

use Textmaster\Api\AbstractApi;
use Textmaster\Exception\InvalidArgumentException;

/**
 * Callbacks.
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
        if (!in_array($event, array('waiting_assignment', 'completed'))) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid callback event.', $event));
        }

        if (!in_array($format, array('json', 'xml'))) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid callback format.', $format));
        }

        return $this->put('clients/users/'.rawurlencode($userId), array(
            'user' => array(
                'callback' => array(
                    $event => array(
                        'url' => $url,
                        'format' => $format
                    )
                )
            )
        ));
    }
}
