<?php

namespace Textmaster\Model;

class Document implements DocumentInterface
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
     * @var ProjectInterface
     */
    protected $project;

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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
    public function setOriginalContent($originalContent)
    {
        $this->originalContent = $originalContent;

        return $this;
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
    public function setTranslatedContent($translatedContent)
    {
        $this->translatedContent = $translatedContent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
