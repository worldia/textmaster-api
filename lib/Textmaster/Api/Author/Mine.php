<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api\Author;

use Textmaster\Api\AbstractApi;
use Textmaster\Exception\InvalidArgumentException;

/**
 * My authors Api.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Mine extends AbstractApi
{
    /**
     * List all my authors.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-get-my-authors
     *
     * @param string $status Possible values: 'my_textmaster', 'blacklisted', 'uncategorized'
     *
     * @return array
     */
    public function all($status = null)
    {
        $params = array();

        if (null !== $status) {
            if (!$this->isValidStatus($status)) {
                throw new InvalidArgumentException(sprintf('"%s" is not valid author status.', $status));
            }
            $params['status'] = $status;
        }

        return $this->get($this->getPath(), $params);
    }

    /**
     * Add an author to my authors.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-get-my-authors
     *
     * @param string      $authorId
     * @param string      $status      Possible values: 'my_textmaster', 'blacklisted', 'uncategorized'
     * @param null|string $description
     *
     * @return array
     */
    public function add($authorId, $status, $description = null)
    {
        if (!$this->isValidStatus($status)) {
            throw new InvalidArgumentException(sprintf('"%s" is not valid author status.', $status));
        }

        $params = array(
            'my_author' => array(
                'author_id' => $authorId,
                'status' => $status,
                ),
            );

        if (null !== $description) {
            $params['my_author']['description'] = $description;
        }

        return $this->post($this->getPath(), $params);
    }

    /**
     * Update an author.
     *
     * @TODO According to doc, 'status' is required.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-update-my-author
     *
     * @param string      $authorId
     * @param string      $status      Possible values: 'my_textmaster', 'blacklisted', 'uncategorized'
     * @param null|string $description
     *
     * @return array
     */
    public function update($authorId, $status, $description = null)
    {
        if (!$this->isValidStatus($status)) {
            throw new InvalidArgumentException(sprintf('"%s" is not valid author status.', $status));
        }

        $params = array(
            'my_author' => array(
                'status' => $status,
                ),
            );

        if (null !== $description) {
            $params['my_author']['description'] = $description;
        }

        return $this->put($this->getPath($authorId), $params);
    }

    /**
     * Get author info.
     *
     * @link https://fr.textmaster.com/documentation#my-authors-get-my-author-info
     *
     * @param string $authorId
     *
     * @return array
     */
    public function info($authorId)
    {
        return $this->get($this->getPath($authorId));
    }

    /**
     * Get api path.
     *
     * @param null|string $authorId
     *
     * @return string
     */
    protected function getPath($authorId = null)
    {
        if (null !== $authorId) {
            return sprintf('clients/my_authors/%s', rawurlencode($authorId));
        }

        return sprintf('clients/my_authors');
    }

    /**
     * Check if the given status is valid.
     *
     * @param string $status
     *
     * @return bool
     */
    protected function isValidStatus($status)
    {
        return in_array($status, array('my_textmaster', 'blacklisted', 'uncategorized'), true);
    }
}
