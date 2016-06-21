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
        $params = [];

        if (null !== $status && in_array($status, ['my_textmaster', 'blacklisted', 'uncategorized'], true)) {
            $params['status'] = $status;
        }

        return $this->get(sprintf('clients/projects/%s/my_authors', $this->projectId), $params);
    }
}
