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
use Gedmo\Translatable\TranslatableListener;

class GedmoTranslatableAdapter extends AbstractDoctrineAdapter
{
    protected $interface = 'Gedmo\Translatable\Translatable';

    /**
     * @var TranslatableListener
     */
    protected $listener;

    /**
     * Constructor.
     *
     * @param ManagerRegistry      $registry
     * @param TranslatableListener $listener
     */
    public function __construct(ManagerRegistry $registry, TranslatableListener $listener)
    {
        parent::__construct($registry);

        $this->listener = $listener;
    }

    /**
     * {@inheritdoc}
     */
    protected function getPropertyHolder($subject, $language, $activity = null)
    {
        $listenerLocale = $this->listener->getListenerLocale();

        if ($listenerLocale !== $language) {
            $subject->setLocale($language);
            $this->getManager($subject)->refresh($subject);
        }

        return $subject;
    }
}
