<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
