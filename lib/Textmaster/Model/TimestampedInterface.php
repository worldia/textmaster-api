<?php

namespace Textmaster\Model;

interface TimestampedInterface
{
    /**
     * Get creation date.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Get date of last update.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}
