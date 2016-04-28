<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Translator\Factory;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Model\ProjectInterface;

class DefaultDocumentFactory implements DocumentFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createDocument($subject, $params = null)
    {
        if (!isset($params['project']) || !$params['project'] instanceof ProjectInterface) {
            throw new InvalidArgumentException('You have to provide a project to create a document.');
        }

        $project = $params['project'];
        $params = isset($params['document']) ? $params['document'] : array();
        $document = $project->createDocument();

        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($params as $property => $value) {
            $accessor->setValue($document, $property, $value);
        }

        return $document;
    }
}
