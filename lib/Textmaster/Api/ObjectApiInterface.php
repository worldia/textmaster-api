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
 * Object Api interface.
 */
interface ObjectApiInterface extends ApiInterface
{
    /**
     * Show a single object.
     *
     * @param string $objectId
     *
     * @return array
     */
    public function show($objectId);

    /**
     * Create an object.
     *
     * @param array $params
     *
     * @return array
     */
    public function create(array $params);

    /**
     * Update an object.
     *
     * @param string $objectId
     * @param array  $params
     *
     * @return array
     */
    public function update($objectId, array $params);
}
