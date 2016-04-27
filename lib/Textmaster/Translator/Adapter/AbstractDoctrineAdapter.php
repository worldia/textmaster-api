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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Textmaster\Exception\UnexpectedTypeException;
use Textmaster\Model\DocumentInterface;
use Textmaster\Manager;

abstract class AbstractDoctrineAdapter extends AbstractAdapter
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

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
    public function complete(DocumentInterface $document)
    {
        $subject = $this->getEntityFromDocument($document);

        if (!$this->supports($subject)) {
            throw new UnexpectedTypeException($subject, $this->interface);
        }

        $properties = $document->getTranslatedContent();
        $language = $document->getProject()->getLanguageTo();

        $this->applyTranslation($subject, $properties, $language);

        $this->persist($subject);

        return $subject;
    }

    /**
     * Get doctrine entity from document parameters.
     *
     * @param DocumentInterface $document
     *
     * @return mixed
     */
    protected function getEntityFromDocument(DocumentInterface $document)
    {
        $params = $document->getCustomData('adapter');

        return $this->getRepository($params['class'])->find($params['id']);
    }

    /**
     * Actually perform completion, ie. set translated values on subject's properties.
     *
     * @param object $subject
     * @param array  $properties
     * @param string $language
     */
    abstract protected function applyTranslation($subject, array $properties, $language);

    /**
     * Get object manager.
     *
     * @param object $subject
     *
     * @return ObjectManager
     */
    protected function getManager($subject)
    {
        return $this->registry->getManagerForClass(is_object($subject) ? get_class($subject) : $subject);
    }

    /**
     * Get object repository.
     *
     * @param object $subject
     *
     * @return ObjectRepository
     */
    protected function getRepository($subject)
    {
        return $this->getManager($subject)->getRepository(is_object($subject) ? get_class($subject) : $subject);
    }

    /**
     * Persist subject.
     *
     * @param object $subject
     */
    protected function persist($subject)
    {
        $manager = $this->getManager($subject);

        $manager->persist($subject);
        $manager->flush();
    }

    /**
     * {@inheritdoc}.
     */
    protected function getParameters($subject)
    {
        return array(
            'class' => get_class($subject),
            'id' => $subject->getId(),
        );
    }
}
