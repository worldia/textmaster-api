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
use Textmaster\Pagination\PagerfantaAdapter;

class Manager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $classes = array(
        'document' => 'Textmaster\Model\Document',
        'project' => 'Textmaster\Model\Project',
    );

    /**
     * Constructor.
     *
     * @param Client $client
     * @param array  $classes
     */
    public function __construct(Client $client, array $classes = array())
    {
        $this->client = $client;
        $this->classes = array_merge($this->classes, $classes);
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
        return new $this->classes['project']($this->client, $id);
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

        return new Pagerfanta(new PagerfantaAdapter($api, $where, $order, true, $this->classes));
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
        return new $this->classes['document'](
            $this->client,
            array('project_id' => $projectId, 'id' => $id)
        );
    }
}
