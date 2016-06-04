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

/**
 * Bundles Api.
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
