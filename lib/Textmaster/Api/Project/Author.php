<?php

namespace Textmaster\Api\Project;

use Textmaster\Api\AbstractApi;
use Textmaster\Client;

/**
 * Project authors Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Author extends AbstractApi
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
     * List all authors.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-get-all-my-authors-who-can-do-this-project
     *
     * @param string $status Possible values: 'my_textmaster', 'blacklisted', 'uncategorized'
     *
     * @return array
     */
    public function all($status = null)
    {
        $params = array();

        if (null !== $status && in_array($status, array('my_textmaster', 'blacklisted', 'uncategorized'))) {
            $params['status'] = $status;
        }

        return $this->get(sprintf('clients/projects/%s/my_authors', $this->projectId), $params);
    }
}
