<?php

namespace Textmaster\Api\Project;

use Textmaster\Api\AbstractApi;
use Textmaster\Api\Project\Document\SupportMessage;

/**
 * Documents Api.
 *
 * @link   https://fr.textmaster.com/documentation#documents-complete-document
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Document extends AbstractApi
{
    /**
     * List all documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-complete-document
     *
     * @param string $projectId
     *
     * @return array
     */
    public function all($projectId)
    {
        return $this->get($this->getPath($projectId));
    }

    /**
     * Filter documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-filter-documents-by-status
     *
     * @param string $projectId
     * @param array  $params
     *
     * @return array
     */
    public function filter($projectId, array $params)
    {
        return $this->get($this->getPath($projectId).'/filter', $params);
    }

    /**
     * Show a single document.
     *
     * @link https://www.textmaster.com/documentation#documents-get-a-document
     *
     * @param string $projectId
     * @param string $documentId
     *
     * @return array
     */
    public function show($projectId, $documentId)
    {
        return $this->get($this->getPath($projectId, $documentId));
    }

    /**
     * Create a document.
     *
     * @link https://www.textmaster.com/documentation#documents-create-a-document
     *
     * @param string $projectId
     * @param array  $params
     *
     * @return array
     */
    public function create($projectId, array $params)
    {
        return $this->post($this->getPath($projectId), array('document' => $params));
    }

    /**
     * Update a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-update-a-document
     *
     * @param string $projectId
     * @param string $documentId
     * @param array  $params
     *
     * @return array
     */
    public function update($projectId, $documentId, array $params)
    {
        return $this->put($this->getPath($projectId, $documentId), $params);
    }

    /**
     * Delete a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-delete-a-document
     *
     * @param string $projectId
     * @param string $documentId
     *
     * @return array
     */
    public function remove($projectId, $documentId)
    {
        return $this->delete($this->getPath($projectId, $documentId));
    }

    /**
     * Complete a document.
     *
     * @link https://fr.textmaster.com/documentation#documents-complete-document
     *
     * @param string      $projectId
     * @param string      $documentId
     * @param null|string $satisfaction One of 'neutral', 'positive' or 'negative'
     * @param null|string $message
     *
     * @return array
     */
    public function complete($projectId, $documentId, $satisfaction = null, $message = null)
    {
        $params = array();

        if (null !== $satisfaction) {
            $params['satisfaction'] = $satisfaction;
        }
        if (null !== $message) {
            $params['message'] = $message;
        }

        return $this->put($this->getPath($projectId, $documentId).'/complete', $params);
    }

    /**
     * Complete multiple documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-complete-multiple-documents
     *
     * @param string      $projectId
     * @param array       $documentIds
     * @param null|string $satisfaction One of 'neutral', 'positive' or 'negative'
     * @param null|string $message
     *
     * @return array
     */
    public function batchComplete($projectId, array $documentIds, $satisfaction = null, $message = null)
    {
        $params = array(
            'documents' => $documentIds,
        );

        if (null !== $satisfaction) {
            $params['satisfaction'] = $satisfaction;
        }
        if (null !== $message) {
            $params['message'] = $message;
        }

        return $this->post('clients/projects/'.rawurlencode($projectId).'/batch/documents/complete', $params);
    }

    /**
     * Create multiple documents.
     *
     * @link https://fr.textmaster.com/documentation#documents-create-multiple-new-documents
     *
     * @param string $projectId
     * @param array  $documents
     *
     * @return array
     */
    public function batchCreate($projectId, array $documents)
    {
        return $this->post('clients/projects/'.rawurlencode($projectId).'/batch/documents', array('documents' => $documents));
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
     * @param string      $projectId
     * @param null|string $documentId
     *
     * @return string
     */
    protected function getPath($projectId, $documentId = null)
    {
        if (null !== $documentId) {
            return sprintf(
                'clients/projects/%s/documents/%s',
                rawurlencode($projectId),
                rawurlencode($documentId)
            );
        }

        return sprintf('clients/projects/%s/documents', rawurlencode($projectId));
    }
}
