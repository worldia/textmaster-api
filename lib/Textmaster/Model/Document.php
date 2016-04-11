<?php

namespace Textmaster\Model;

class Document implements DocumentInterface
{
    /**
     * @var string
     */
    private $textMasterId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $originalContent;

    /**
     * @var string
     */
    private $translatedContent;

    /**
     * @var ProjectInterface
     */
    private $project;

    /**
     * @return string
     */
    public function getTextMasterId()
    {
        return $this->textMasterId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getOriginalContent()
    {
        return $this->originalContent;
    }

    /**
     * @return string
     */
    public function getTranslatedContent()
    {
        return $this->translatedContent;
    }

    /**
     * @return ProjectInterface
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $textMasterId
     *
     * @return Document
     */
    public function setTextMasterId($textMasterId)
    {
        $this->textMasterId = $textMasterId;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return Document
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $originalContent
     *
     * @return Document
     */
    public function setOriginalContent($originalContent)
    {
        $this->originalContent = $originalContent;

        return $this;
    }

    /**
     * @param string $translatedContent
     *
     * @return Document
     */
    public function setTranslatedContent($translatedContent)
    {
        $this->translatedContent = $translatedContent;

        return $this;
    }

    /**
     * @param ProjectInterface $project
     *
     * @return Document
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }
}
