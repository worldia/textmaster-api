<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api\Project\Document;

use Textmaster\Api\AbstractApi;

/**
 * Support messages Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class SupportMessage extends AbstractApi
{
    /**
     * List all support messages.
     *
     * @link https://fr.textmaster.com/documentation#support-messages-get-all-support-messages
     *
     * @param string $projectId
     * @param string $documentId
     *
     * @return array
     */
    public function all($projectId, $documentId)
    {
        return $this->get($this->getPath($projectId, $documentId));
    }

    /**
     * Create a support message.
     *
     * @link https://fr.textmaster.com/documentation#support-messages-create-a-support-message
     *
     * @param string $projectId
     * @param string $documentId
     * @param string $message
     *
     * @return array
     */
    public function create($projectId, $documentId, $message)
    {
        return $this->post($this->getPath($projectId, $documentId), array(
            'support_message' => array('message' => $message),
        ));
    }

    /**
     * Get api path.
     *
     * @param string $projectId
     * @param string $documentId
     *
     * @return string
     */
    protected function getPath($projectId, $documentId)
    {
        return sprintf(
            'clients/projects/%s/documents/%s/support_messages',
            rawurlencode($projectId),
            rawurlencode($documentId)
        );
    }
}
