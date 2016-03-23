<?php

namespace Textmaster\Api;

/**
 * Listing bundles.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Bundle extends AbstractApi
{
    /**
     * List all bundles.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-bundles
     *
     * @return array
     */
    public function all()
    {
        return $this->get('public/bundles');
    }
}
