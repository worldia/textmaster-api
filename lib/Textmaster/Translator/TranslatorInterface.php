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

interface TranslatorInterface
{
    /**
     * Launch a translation.
     *
     * @param mixed                   $subject
     * @param mixed|DocumentInterface $documentOrParams Either pass a document instance
     *                                                  or parameters to pass on to a defined DocumentFactoryInterface
     *
     * @return DocumentInterface
     */
    public function create($subject, $documentOrParams = null);

    /**
     * Complete a translation.
     *
     * @param DocumentInterface $document
     *
     * @return mixed The subject passed on creation.
     */
    public function complete(DocumentInterface $document);
}
