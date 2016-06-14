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

use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Model\ProjectInterface;

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

    /**
     * List all available locales for an ability.
     *
     * @param string      $ability Can be one of ProjectInterface::ACTIVITY
     * @param int         $page
     * @param string|null $locale
     *
     * @return array
     */
    public function abilities($ability, $page, $locale = null)
    {
        $abilities = [
            ProjectInterface::ACTIVITY_TRANSLATION,
            ProjectInterface::ACTIVITY_COPYWRITING,
            ProjectInterface::ACTIVITY_PROOFREADING,
        ];
        
        if (!in_array($ability, $abilities)) {
            throw new InvalidArgumentException('Invalid ability');
        }
        
        if (!is_int($page)) {
            throw new InvalidArgumentException('Invalid page number');
        }

        $queryParameters = ['activity' => $ability, 'page' => $page];

        if (null !== $locale) {
            $queryParameters['locale'] = $locale;
        }

        return $this->get('clients/abilities', $queryParameters);
    }
}
