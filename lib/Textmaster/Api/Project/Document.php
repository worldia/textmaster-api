<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api\Project;

use Textmaster\Api\AbstractApi;
use Textmaster\Api\FilterableApiInterface;
use Textmaster\Api\ObjectApiInterface;
use Textmaster\Api\Project\Document\SupportMessage;
use Textmaster\Client;

/**
 * Documents Api.
 *
 * @link   https://fr.textmaster.com/documentation#documents-complete-document
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Document extends AbstractApi implements ObjectApiInterface, FilterableApiInterface
{
    /**
     * @var string
     */
    protected $projectId;

    /**
     * {@inheritdoc}
     *
     * @param string $projectId
     */
    public function __construct(Client $client, $projectId)
    {
        parent::__construct($client);

        $this->projectId = $projectId;
    }

    /**
     * List all documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-list-all-documents-in-a-project
     *
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath());
    }

    /**
     * Filter documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-filter-documents-by-status
     *
     * @param array $where
     * @param array $order
     *
     * @return array
     */
    public function filter(array $where = [], array $order = [])
    {
        $params = [];

        empty($where) ?: $params['where'] = json_encode($where);
        empty($order) ?: $params['order'] = json_encode($order);

        return $this->get($this->getPath().'/filter', $params);
    }

    /**
     * Show a single document.
     *
     * @link https://www.textmaster.com/documentation#documents-get-a-document
     *
     * @param string $documentId
     *
     * @return array
     */
    public function show($documentId)
    {
        return $this->get($this->getPath($documentId));
    }

    /**
     * Create a document.
     *
     * @link https://www.textmaster.com/documentation#documents-create-a-document
     *
     * @param array $params
     *
     * @return array
     */
    public function create(array $params)
    {
        return $this->post($this->getPath(), ['document' => $params]);
    }

    /**
     * Update a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-update-a-document
     *
     * @param string $documentId
     * @param array  $params
     *
     * @return array
     */
    public function update($documentId, array $params)
    {
        return $this->put($this->getPath($documentId), $params);
    }

    /**
     * Delete a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-delete-a-document
     *
     * @param string $documentId
     *
     * @return array
     */
    public function remove($documentId)
    {
        return $this->delete($this->getPath($documentId));
    }

    /**
     * Complete a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-complete-document
     *
     * @param string      $documentId
     * @param null|string $satisfaction One of 'neutral', 'positive' or 'negative'
     * @param null|string $message
     *
     * @return array
     */
    public function complete($documentId, $satisfaction = null, $message = null)
    {
        $params = [];

        if (null !== $satisfaction) {
            $params['satisfaction'] = $satisfaction;
        }
        if (null !== $message) {
            $params['message'] = $message;
        }

        return $this->put($this->getPath($documentId).'/complete', $params);
    }

    /**
     * Complete multiple documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-complete-multiple-documents
     *
     * @param array       $documentIds
     * @param null|string $satisfaction One of 'neutral', 'positive' or 'negative'
     * @param null|string $message
     *
     * @return array
     */
    public function batchComplete(array $documentIds, $satisfaction = null, $message = null)
    {
        $params = [
            'documents' => $documentIds,
        ];

        if (null !== $satisfaction) {
            $params['satisfaction'] = $satisfaction;
        }
        if (null !== $message) {
            $params['message'] = $message;
        }

        return $this->post('clients/projects/'.rawurlencode($this->projectId).'/batch/documents/complete', $params);
    }

    /**
     * Create multiple documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-create-multiple-new-documents
     *
     * @param array $documents
     *
     * @return array
     */
    public function batchCreate(array $documents)
    {
        return $this->post('clients/projects/'.rawurlencode($this->projectId).'/batch/documents', ['documents' => $documents]);
    }

    /**
     * Support messages api.
     *
     * @return SupportMessage
     */
    public function supportMessages()
    {
        return new SupportMessage($this->client);
    }

    /**
     * Get api path.
     *
     * @param null|string $documentId
     *
     * @return string
     */
    protected function getPath($documentId = null)
    {
        if (null !== $documentId) {
            return sprintf(
                'clients/projects/%s/documents/%s',
                rawurlencode($this->projectId),
                rawurlencode($documentId)
            );
        }

        return sprintf('clients/projects/%s/documents', rawurlencode($this->projectId));
    }
}
