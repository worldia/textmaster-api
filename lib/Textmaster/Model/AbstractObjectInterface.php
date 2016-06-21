<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Model;

interface AbstractObjectInterface
{
    /**
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get raw data.
     *
     * @return array
     */
    public function getData();

    /**
     * Save the object.
     *
     * @return AbstractObjectInterface
     */
    public function save();
}
