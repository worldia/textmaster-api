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
     * Make a comparison between textmaster document and its subject.
     *
     * @param DocumentInterface $document
     *
     * @return array
     */
    public function compare(DocumentInterface $document);

    /**
     * Complete a translation.
     *
     * @param DocumentInterface $document
     * @param string            $satisfaction
     * @param string            $message
     *
     * @return mixed The subject passed on creation.
     */
    public function complete(DocumentInterface $document, $satisfaction = null, $message = null);

    /**
     * Get subject from document.
     *
     * @param DocumentInterface $document
     *
     * @return mixed
     */
    public function getSubjectFromDocument(DocumentInterface $document);
}
