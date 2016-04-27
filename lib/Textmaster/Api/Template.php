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
 * Work templates Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Template extends AbstractApi
{
    /**
     * List all languages.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-languages
     *
     * @return array
     */
    public function all()
    {
        return $this->get('clients/work_templates');
    }

    /**
     * Get a template.
     *
     * @link https://fr.textmaster.com/documentation#language-levels-get-all-language-levels
     *
     * @param string $name
     *
     * @return array
     */
    public function byName($name)
    {
        return $this->get('clients/work_templates/'.rawurlencode($name));
    }
}
