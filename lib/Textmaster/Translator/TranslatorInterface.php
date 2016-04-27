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

interface TranslatorInterface
{
    /**
     * Launch a translation.
     *
     * @param mixed                                     $subject
     * @param array                                     $properties
     * @param ProjectInterface|DocumentInterface|string $documentOrProject
     *
     * @return DocumentInterface
     */
    public function create($subject, $documentOrProject);

    /**
     * Complete a translation.
     *
     * @param DocumentInterface $document
     *
     * @return mixed The subject passed on creation.
     */
    public function complete(DocumentInterface $document);
}
