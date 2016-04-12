<?php

namespace Textmaster\Api;

/**
 * Categories Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Category extends AbstractApi
{
    /**
     * List all categories.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-categories
     *
     * @return array
     */
    public function all()
    {
        return $this->get('public/categories');
    }
}
