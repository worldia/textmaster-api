<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Model;

class Author extends AbstractObject implements AuthorInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getAuthorId()
    {
        return $this->getProperty('author_id');
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthorId($authorId)
    {
        return $this->setProperty('author_id', $authorId);
    }

    /**
     * Get the Author Api object.
     *
     * @return \Textmaster\Api\Author
     */
    protected function getApi()
    {
        return $this->client->authors();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEventNamePrefix()
    {
        return 'textmaster.author';
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getProperty('status');
    }

    /**
     * {@inheritdoc}
     */
    protected function isImmutable()
    {
        return true;
    }
}
