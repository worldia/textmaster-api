<?php

namespace Textmaster\Api\Project;

use Textmaster\Api\AbstractApi;

/**
 * Project authors Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Author extends AbstractApi
{
    /**
     * List all authors.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-get-all-my-authors-who-can-do-this-project
     *
     * @param string $projectId
     * @param string $status    Possible values: 'my_textmaster', 'blacklisted', 'uncategorized'
     *
     * @return array
     */
    public function all($projectId, $status = null)
    {
        $params = array();

        if (null !== $status && in_array($status, array('my_textmaster', 'blacklisted', 'uncategorized'))) {
            $params['status'] = $status;
        }

        return $this->get(sprintf('clients/projects/%s/my_authors', $projectId), $params);
    }
}
