<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Translator\Adapter;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Textmaster\Model\DocumentInterface;
use Textmaster\Exception\UnexpectedTypeException;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var string
     */
    protected $interface;

    /**
     * {@inheritdoc}
     */
    public function supports($subject)
    {
        return $subject instanceof $this->interface;
    }

    /**
     * {@inheritdoc}
     */
    public function create($subject, array $properties, DocumentInterface $document)
    {
        if (!$subject instanceof $this->interface) {
            throw new UnexpectedTypeException($subject, $this->interface);
        }

        $content = $this->getProperties($subject, $properties);

        return $document
            ->setOriginalContent($content)
            ->setCustomData($this->getParameters($subject), 'adapter')
            ->save()
        ;
    }

    /**
     * Set properties on given subject.
     *
     * @param object $subject
     * @param array  $properties Array of 'property' => 'value' pairs.
     */
    protected function setProperties($subject, array $properties)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($properties as $property => $content) {
            $accessor->setValue($subject, $property, $content);
        }
    }

    /**
     * Get properties from given subject.
     *
     * @param object $subject
     * @param array  $properties Array of 'properties'
     *
     * @return array
     */
    protected function getProperties($subject, array $properties)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $data = array();

        foreach ($properties as $property) {
            $data[$property] = $accessor->getValue($subject, $property);
        }

        return $data;
    }

    /**
     * Get parameters to be stored in document hash
     * to allow retrieval later on.
     *
     * @param object $subject
     *
     * @return array
     */
    abstract protected function getParameters($subject);
}
