<?php

namespace Textmaster\Model;

class Project implements ProjectInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var DocumentInterface[]
     */
    protected $documents;
}
