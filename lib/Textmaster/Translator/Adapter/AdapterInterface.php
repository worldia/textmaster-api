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
     * @return bool
     */
    public function supports($subject);

    /**
     * Launch a translation.
     *
     * @param mixed             $subject
     * @param array             $properties
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     */
    public function create($subject, array $properties, DocumentInterface $document);

    /**
     * Complete a translation.
     *
     * @param DocumentInterface $document
     * @param string            $satisfaction
     * @param string            $message
     *
     * @return mixed
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
