<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster;

use Pagerfanta\Pagerfanta;
use Textmaster\Api\FilterableApiInterface;

class Manager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get project by id or create a new one.
     *
     * @param string $id the project's id
     *
     * @return Model\ProjectInterface
     */
    public function getProject($id = null)
    {
        return new Model\Project($this->client, $id);
    }

    /**
     * Get projects.
     *
     * @param array $where criteria to filter projects.
     * @param array $order criteria to order projects.
     *
     * @return Pagerfanta
     */
    public function getProjects(array $where = array(), array $order = array())
    {
        /** @var FilterableApiInterface $api */
        $api = $this->client->api('projects');

        return new Pagerfanta(new PagerfantaAdapter($api, $where, $order));
    }

    /**
     * Get document by project id and id.
     *
     * @param string $projectId the project's id
     * @param string $id        the document's id
     *
     * @return Model\DocumentInterface
     */
    public function getDocument($projectId, $id)
    {
        return new Model\Document(
            $this->client,
            array('project_id' => $projectId, 'id' => $id)
        );
    }
}
