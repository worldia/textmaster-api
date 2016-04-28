<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Translator\Factory;

use Textmaster\Model\DocumentInterface;

interface DocumentFactoryInterface
{
    /**
     * Get or create a document.
     *
     * @param mixed $subject
     * @param mixed $params
     *
     * @return DocumentInterface
     */
    public function createDocument($subject, $params = null);
}
