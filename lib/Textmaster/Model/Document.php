<?php

namespace Textmaster\Model;

class Document extends TextmasterObject implements DocumentInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $originalContent;

    /**
     * @var string
     */
    protected $translatedContent;

    /**
     * @var string
     */
    protected $projectId;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalContent()
    {
        return $this->originalContent;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslatedContent()
    {
        return $this->translatedContent;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectId()
    {
        return $this->projectId;
    }
}
