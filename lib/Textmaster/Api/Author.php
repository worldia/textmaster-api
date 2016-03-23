<?php

namespace Textmaster\Api;

use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Api\Author\Mine;

/**
 * Listing authors.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Author extends AbstractApi
{
    /**
     * Find potential authors for a project.
     *
     * @link https://fr.textmaster.com/documentation#potential-authors-for-a-project-list-all-potential-authors-for-a-translation-project
     *
     * @param  array  $params
     *
     * @return array
     */
    public function find(array $params)
    {
        foreach ($params as $name => $value) {
            if (!in_array($name, array(
                'name',
                'ctype',
                'options',
                'language_from',
                'language_to',
                'project_briefing',
                'category'
            ))) {
                throw new InvalidArgumentException(sprintf('"%s" is not a valid author search parameter.', $name));
            }
        }

        return $this->get('clients/authors', $params);
    }

    /**
     * My authors Api.
     *
     * @return Mine
     */
    public function mine()
    {
        return new Mine($this->client);
    }
}
