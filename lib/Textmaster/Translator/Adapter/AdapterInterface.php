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

use Textmaster\Model\DocumentInterface;

interface AdapterInterface
{
    /**
     * Whether the adapter supports the given subject.
     *
     * @param mixed $subject
     *
     * @return bool
     */
    public function supports($subject);

    /**
     * Push document to textmaster.
     *
     * @param mixed             $subject
     * @param array             $properties
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     */
    public function push($subject, array $properties, DocumentInterface $document);

    /**
     * Make a comparison between textmaster document and its subject.
     *
     * @param DocumentInterface $document
     *
     * @return array
     */
    public function compare(DocumentInterface $document);

    /**
     * Complete a document.
     *
     * @param DocumentInterface $document
     * @param string            $satisfaction
     * @param string            $message
     *
     * @return DocumentInterface
     */
    public function complete(DocumentInterface $document, $satisfaction = null, $message = null);

    /**
     * Pull document from textmaster.
     *
     * @param DocumentInterface $document
     *
     * @return mixed The subject passed on creation.
     */
    public function pull(DocumentInterface $document);

    /**
     * Get subject from document.
     *
     * @param DocumentInterface $document
     *
     * @return mixed
     */
    public function getSubjectFromDocument(DocumentInterface $document);
}
