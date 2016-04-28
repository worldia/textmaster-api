<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Translator\Provider;

interface MappingProviderInterface
{
    /**
     * Get an array of properties that are to be translated for the given subject.
     *
     * @param mixed $subject
     *
     * @return array of properties to be translated.
     */
    public function getProperties($subject);
}
