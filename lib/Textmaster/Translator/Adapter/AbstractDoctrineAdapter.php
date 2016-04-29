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
use Doctrine\Common\Persistence\ObjectRepository;
use Textmaster\Model\DocumentInterface;

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
    public function complete(DocumentInterface $document, $satisfaction = null, $message = null)
    {
        $subject = parent::complete($document, $satisfaction, $message);

        $this->persist($subject);

        return $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubjectFromDocument(DocumentInterface $document)
    {
        $params = $document->getCustomData('adapter');

        return $this->getRepository($params['class'])->find($params['id']);
    }

    /**
     * {@inheritdoc}.
     */
    protected function setSubjectOnDocument($subject, DocumentInterface $document)
    {
        $document->setCustomData(
            array(
                'class' => get_class($subject),
                'id' => $subject->getId(),
            ),
            'adapter'
        );
    }

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
}
