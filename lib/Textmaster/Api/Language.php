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
 * Language and LanguageLevel Apis.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Language extends AbstractApi
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
        return $this->get('public/languages');
    }

    /**
     * List all language levels.
     *
     * @link https://fr.textmaster.com/documentation#language-levels-get-all-language-levels
     *
     * @return array
     */
    public function levels()
    {
        return $this->get('clients/language_levels');
    }
}
