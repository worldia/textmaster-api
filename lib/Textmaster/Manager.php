<?php

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
}
