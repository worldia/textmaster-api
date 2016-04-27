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

use Textmaster\Manager;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;
use Textmaster\Translator\Provider\MappingProviderInterface;
use Textmaster\Exception\InvalidArgumentException;

class Translator implements TranslatorInterface
{
    /**
     * @var Manager
     */
    protected $textmaster;

    /**
     * @var Adapter\AdapterInterface[]
     */
    protected $adapters;

    /**
     * @var MappingProviderInterface
     */
    protected $mappingProvider;

    /**
     * Constructor.
     *
     * @param Manager                    $textmaster
     * @param Adapter\AdapterInterface[] $adapters
     * @param MappingProviderInterface   $mappingProvider
     */
    public function __construct(Manager $textmaster, array $adapters, MappingProviderInterface $mappingProvider)
    {
        $this->textmaster = $textmaster;
        $this->adapters = $adapters;
        $this->mappingProvider = $mappingProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function create($subject, $documentOrProject)
    {
        if ($documentOrProject instanceof DocumentInterface) {
            $document = $documentOrProject;
        } elseif ($documentOrProject instanceof ProjectInterface) {
            $document = $documentOrProject->createDocument();
        } elseif (is_string($documentOrProject)) {
            $document = $this->textmaster->getProject($documentOrProject)->createDocument();
        } elseif (is_array($documentOrProject)) {
            $project = $this->textmaster->getProject($documentOrProject);
            $project->save();
            $document = $project->createDocument();
        }

        if (!isset($document)) {
            throw new InvalidArgumentException('Couldnt determine document.');
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
            if ($adapter->supports($subject)) {
                return $adapter->complete($document);
            }
        }

        throw new InvalidArgumentException(sprintf('No adapter found for "%s".', get_class($subject)));
    }
}
