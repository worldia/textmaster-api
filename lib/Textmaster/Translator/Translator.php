<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Translator;

use Textmaster\Model\DocumentInterface;
use Textmaster\Translator\Factory\DocumentFactoryInterface;
use Textmaster\Translator\Provider\MappingProviderInterface;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\UnexpectedTypeException;

class Translator implements TranslatorInterface
{
    /**
     * @var Adapter\AdapterInterface[]
     */
    protected $adapters;

    /**
     * @var MappingProviderInterface
     */
    protected $mappingProvider;

    /**
     * @var DocumentFactoryInterface|null
     */
    protected $documentFactory;

    /**
     * Constructor.
     *
     * @param Adapter\AdapterInterface[]    $adapters
     * @param MappingProviderInterface      $mappingProvider
     * @param DocumentFactoryInterface|null $documentFactory
     */
    public function __construct(
        array $adapters,
        MappingProviderInterface $mappingProvider,
        DocumentFactoryInterface $documentFactory = null
    ) {
        $this->adapters = $adapters;
        $this->mappingProvider = $mappingProvider;
        $this->documentFactory = $documentFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create($subject, $documentOrParams = null)
    {
        $document = $documentOrParams;

        if (!$document instanceof DocumentInterface) {
            $document = $this->getDocumentFactory()->createDocument($subject, $documentOrParams);
        }

        $properties = $this->mappingProvider->getProperties($subject);

        foreach ($this->adapters as $adapter) {
            if ($adapter->supports($subject)) {
                return $adapter->create($subject, $properties, $document);
            }
        }

        throw new InvalidArgumentException(sprintf('No adapter found for "%s".', get_class($subject)));
    }

    /**
     * {@inheritdoc}
     */
    public function complete(DocumentInterface $document)
    {
        foreach ($this->adapters as $adapter) {
            try {
                return $adapter->complete($document);
            } catch (UnexpectedTypeException $e) {
                continue;
            }
        }

        throw new InvalidArgumentException(sprintf('No adapter found for "%s".', get_class($subject)));
    }

    private function getDocumentFactory()
    {
        if (null === $this->documentFactory) {
            throw new InvalidArgumentException('No document factory provided.');
        }

        return $this->documentFactory;
    }
}
