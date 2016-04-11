<?php

namespace Textmaster\Model;

class Project implements ProjectInterface
{
    /**
     * @var string
     */
    private $textMasterId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $ctype;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $languageFrom;

    /**
     * @var string
     */
    private $languageTo;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $projectBriefing;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $documents;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCtype()
    {
        return $this->ctype;
    }

    /**
     * Get allowed values for ctype.
     *
     * @return array
     */
    public function getAllowedCtypes()
    {
        return array(
            ProjectInterface::CTYPE_COPYWRITING,
            ProjectInterface::CTYPE_PROOFREADING,
            ProjectInterface::CTYPE_TRANSLATION,
        );
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
    public function getLanguageFrom()
    {
        return $this->languageFrom;
    }

    /**
     * @return string
     */
    public function getLanguageTo()
    {
        return $this->languageTo;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getProjectBriefing()
    {
        return $this->projectBriefing;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get documents.
     *
     * @return array
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add a document.
     *
     * @param DocumentInterface $document
     */
    public function addDocument(DocumentInterface $document)
    {
        $document->setProject($this);
        $this->documents[] = $document;
    }

    /**
     * Remove a document.
     *
     * @param DocumentInterface $document
     */
    public function removeDocument(DocumentInterface $document)
    {
        $document->setProject(null);
        $key = array_search($document, $this->documents);

        unset($this->documents[$key]);
    }

    /**
     * @param string $textMasterId
     *
     * @return Project
     */
    public function setTextMasterId($textMasterId)
    {
        $this->textMasterId = $textMasterId;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $ctype
     *
     * @return Project
     */
    public function setCtype($ctype)
    {
        $this->ctype = $ctype;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $languageFrom
     *
     * @return Project
     */
    public function setLanguageFrom($languageFrom)
    {
        $this->languageFrom = $languageFrom;

        return $this;
    }

    /**
     * @param string $languageTo
     *
     * @return Project
     */
    public function setLanguageTo($languageTo)
    {
        $this->languageTo = $languageTo;

        return $this;
    }

    /**
     * @param string $category
     *
     * @return Project
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param string $projectBriefing
     *
     * @return Project
     */
    public function setProjectBriefing($projectBriefing)
    {
        $this->projectBriefing = $projectBriefing;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return Project
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}
