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

use Textmaster\Api\Expertise\SubExpertise;

/**
 * Expertises Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Expertise extends AbstractApi
{
    /**
     * List all languages.
     *
     * @link https://fr.textmaster.com/documentation#public-listing-languages
     *
     * @param string      $activity
     * @param null|string $locale
     *
     * @return array
     */
    public function all($activity, $locale = null)
    {
        $params = ['activity' => $activity];

        if (null !== $locale) {
            $params['locale'] = $locale;
        }

        return $this->get('public/expertises', $params);
    }

    /**
     * Sub expertise Api.
     *
     * @return SubExpertise
     */
    public function subExpertises()
    {
        return new SubExpertise($this->client);
    }
}
