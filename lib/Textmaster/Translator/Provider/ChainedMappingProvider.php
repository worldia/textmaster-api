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

class ChainedMappingProvider implements MappingProviderInterface
{
    /**
     * @var MappingProviderInterface[]
     */
    protected $providers;

    /**
     * @param MappingProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties($subject)
    {
        foreach ($providers as $provider) {
            try {
                return $provider->getProperties($subject);
            } catch (MappingNotFoundException $e) {
                continue;
            }
        }

        throw new MappingNotFoundException($subject);
    }
}
