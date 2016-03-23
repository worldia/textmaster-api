<?php

namespace Textmaster\Api;

use Textmaster\Api\User\Callback;

/**
 * Users.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class User extends AbstractApi
{
    /**
     * Get information about current user.
     *
     * @link https://fr.textmaster.com/documentation#users-get-information-about-myself
     *
     * @return array
     */
    public function me()
    {
        return $this->get('clients/users/me');
    }

    /**
     * Callbacks Api.
     *
     * @return Callback
     */
    public function callbacks()
    {
        return new Callback($this->client);
    }
}
