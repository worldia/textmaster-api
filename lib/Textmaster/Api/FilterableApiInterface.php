<?php

namespace Textmaster\Api;

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
}
