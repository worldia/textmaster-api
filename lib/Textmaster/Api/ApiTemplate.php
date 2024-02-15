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

/**
 * ApiTemplates Api.
 *
 * @author JM Leroux <jean-marie.leroux@akeneo.com>
 */
class ApiTemplate extends AbstractApi
{
    /**
     * List all API templates.
     *
     * @link https://fr.textmaster.com/documentation#api-templates-list-api-templates
     *
     * @return array
     */
    public function all($page = 1, $perPage = 100)
    {
        $query = http_build_query([
            'page' => $page,
            'per_page' => $perPage,
        ]);

        return $this->get('clients/api_templates?' . $query);
    }
}
