<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api;

use Textmaster\Api\Author\Mine;
use Textmaster\Exception\InvalidArgumentException;

/**
 * Authors Api.
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
     * @param array $params
     *
     * @return array
     */
    public function find(array $params)
    {
        foreach ($params as $name => $value) {
            if (!in_array($name, [
                'name',
                'ctype',
                'options',
                'language_from',
                'language_to',
                'project_briefing',
                'category',
            ], true)) {
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
