<?php

namespace Textmaster\Model;

class Document extends AbstractObject implements DocumentInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $projectId;

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
    protected $translatedContent;

    /**
     * @var string
     */
    protected $originalContent;

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
    public function getProjectId()
    {
        return $this->projectId;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * {@inheritdoc}
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

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
    public function getOriginalContent()
    {
        return $this->originalContent;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalContent($content)
    {
        $this->originalContent = $content;

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
    protected function isImmutable()
    {
        return $this->status === self::STATUS_IN_CREATION;
    }
}
