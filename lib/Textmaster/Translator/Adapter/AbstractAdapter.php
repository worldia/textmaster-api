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
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\UnexpectedTypeException;
use Textmaster\Model\DocumentInterface;

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
        $this->failIfDoesNotSupport($subject);

        $language = $document->getProject()->getLanguageFrom();
        $content = $this->getProperties($subject, $properties, $language);

        $this->setSubjectOnDocument($subject, $document);

        $document->setOriginalContent($content);

        return $document;
    }

    /**
     * {@inheritdoc}
     */
    public function compare(DocumentInterface $document)
    {
        $subject = $this->getSubjectFromDocument($document);
        $this->failIfDoesNotSupport($subject);

        $original = $this->compareContent(
            $subject,
            $document->getOriginalContent(),
            $document->getProject()->getLanguageFrom(),
            true
        );

        $translated = $this->compareContent(
            $subject,
            $document->getTranslatedContent(),
            $document->getProject()->getLanguageTo(),
            false
        );

        return array(
            'original' => $original,
            'translated' => $translated,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function complete(DocumentInterface $document, $satisfaction = null, $message = null)
    {
        $subject = $this->getSubjectFromDocument($document);
        $this->failIfDoesNotSupport($subject);

        /** @var array $properties */
        $properties = $document->getTranslatedContent();
        $language = $document->getProject()->getLanguageTo();

        $this->setProperties($subject, $properties, $language);

        $document->complete($satisfaction, $message);

        return $subject;
    }

    /**
     * Compare given content with the subject's one in the given language.
     *
     * @param mixed  $subject
     * @param array  $content
     * @param string $language
     * @param bool   $original
     *
     * @return array
     */
    protected function compareContent($subject, array $content, $language, $original = true)
    {
        $properties = array_keys($content);
        $values = $this->getProperties($subject, $properties, $language, false);

        $diffs = array();
        $renderer = new \Diff_Renderer_Html_SideBySide();
        foreach ($values as $property => $value) {
            $a = array($value);
            $b = array($content[$property]);
            if ($original) {
                $b = array($content[$property]['original_phrase']);
            }

            $diff = new \Diff($a, $b);
            $diffs[$property] = $diff->render($renderer);
        }

        return $diffs;
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
     * @param bool   $original   if true return array of 'property' => array('original_phrase' => 'value')
     *                           else return array of 'property' => 'value'
     *
     * @return array
     */
    protected function getProperties($subject, array $properties, $language, $original = true)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $holder = $this->getPropertyHolder($subject, $language);

        $data = array();
        foreach ($properties as $property) {
            $value = $accessor->getValue($holder, $property);

            if (empty($value)) {
                // Textmaster rejects empty strings
                continue;
            }

            if ($original) {
                $value = array('original_phrase' => $value);
            }

            $data[$property] = $value;
        }

        if (!count($data)) {
            throw new InvalidArgumentException(sprintf(
                'Object of type "%s" has no translatable properties to translate (ie. non-empty). Checked for: "%s"',
                get_class($subject),
                implode(', ', $properties)
            ));
        }

        return $data;
    }

    /**
     * Throw exception if the adapter does not support the subject.
     *
     * @param mixed $subject
     *
     * @throws UnexpectedTypeException
     */
    protected function failIfDoesNotSupport($subject)
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
