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

use Textmaster\Exception\MappingNotFoundException;

class ArrayBasedMappingProvider implements MappingProviderInterface
{
    /**
     * @var array
     */
    protected $mappings;

    /**
     * @param array $mappings
     */
    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties($subject)
    {
        $class = get_class($subject);

        if (!isset($mappings[$class]) || !is_array($mappings[$class])) {
            throw new MappingNotFoundException($subject);
        }

        return $this->mappings[$class];
    }
}
