<?php

namespace Textmaster\Api;

use Textmaster\Client;

/**
 * Filterable Api interface.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
interface FilterableApiInterface
{
    /**
     * Filter objects.
     *
     * @param array $where
     * @param array $order
     *
     * @return array
     */
    public function filter(array $where = array(), array $order = array());

    /**
     * Get API client.
     *
     * @return Client
     */
    public function getClient();
}
