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
        $this->failIfDoesntSupport($subject);

        $language = $document->getProject()->getLanguageFrom();
        $content = $this->getProperties($subject, $properties, $language);

        $this->setSubjectOnDocument($subject, $document);

        return $document->setOriginalContent($content)->save();
    }

    /**
     * {@inheritdoc}
     */
    public function complete(DocumentInterface $document, $satisfaction = null, $message = null)
    {
        $subject = $this->getSubjectFromDocument($document);
        $this->failIfDoesntSupport($subject);

        /** @var array $properties */
        $properties = $document->getTranslatedContent();
        $language = $document->getProject()->getLanguageTo();

        $this->setProperties($subject, $properties, $language);

        $document->complete($satisfaction, $message);

        return $subject;
    }

    /**
     * Set properties on given subject.
     *
     * @param object $subject
     * @param array  $properties Array of 'property' => 'value' pairs.
     * @param string $language
     */
    protected function setProperties($subject, array $properties, $language)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $holder = $this->getPropertyHolder($subject, $language);

        foreach ($properties as $property => $value) {
            $accessor->setValue($holder, $property, $value);
        }
    }

    /**
     * Get properties from given subject.
     *
     * @param object $subject
     * @param array  $properties Array of 'properties'
     * @param string $language
     *
     * @return array of 'property' => array('original_phrase' => 'value')
     */
    protected function getProperties($subject, array $properties, $language)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $holder = $this->getPropertyHolder($subject, $language);

        $data = array();

        foreach ($properties as $property) {
            $data[$property] = array('original_phrase' => $accessor->getValue($holder, $property));
        }

        return $data;
    }

    /**
     * Throw exception if the adapter doesn't support the subject.
     *
     * @param mixed $subject
     *
     * @throws UnexpectedTypeException
     */
    protected function failIfDoesntSupport($subject)
    {
        if (!$this->supports($subject)) {
            throw new UnexpectedTypeException($subject, $this->interface);
        }
    }

    /**
     * Get subject from document.
     *
     * @param DocumentInterface $document
     *
     * @return mixed
     */
    abstract public function getSubjectFromDocument(DocumentInterface $document);

    /**
     * Attach the subject to the document so it can be retrieved
     * through the above getter later on.
     *
     * @param object            $subject
     * @param DocumentInterface $document
     */
    abstract protected function setSubjectOnDocument($subject, DocumentInterface $document);

    /**
     * Get object holding translated properties:
     * 1/ Used to get values in source language
     * 2/ Used to set values in destination language.
     *
     * @param object $subject
     * @param string $language
     *
     * @return mixed
     */
    abstract protected function getPropertyHolder($subject, $language);
}
