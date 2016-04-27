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

class GedmoTranslatableAdapter extends AbstractDoctrineAdapter
{
    protected $interface = 'Gedmo\Translatable\Translatable';

    /**
     * {@inheritdoc}
     */
    protected function applyTranslation($subject, array $properties, $language)
    {
        $subject->setTranslatableLocale($language);
        $this->setProperties($subject, $properties);
    }
}
