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
 * Locales listing, reference pricings and localized countries.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Locale extends AbstractApi
{
    /**
     * List all locales.
     *
     * TODO: Available at two URLs, why?
     *
     * @link https://fr.textmaster.com/documentation#locales-listing-locales
     * @link https://fr.textmaster.com/documentation#public-listing-locales
     *
     * @return array
     */
    public function all()
    {
        return $this->get('public/locales');
    }

    /**
     * List public reference pricings.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-localized-reference-pricings
     *
     * @param string $locale
     *
     * @return array
     */
    public function referencePricings($locale)
    {
        return $this->get('public/reference_pricings/'.rawurlencode($locale));
    }

    /**
     * List country names.
     *
     * TODO: Locale not required in URL as per docs.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-localized-country-names
     *
     * @param string $locale
     *
     * @return array
     */
    public function countries($locale)
    {
        return $this->get('public/countries/'.rawurlencode($locale));
    }
}
