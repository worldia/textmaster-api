<?php

namespace Textmaster\Model;

class Project implements ProjectInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $ctype;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $languageFrom;

    /**
     * @var string
     */
    protected $languageTo;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $projectBriefing;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $documents;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCtype()
    {
        return $this->ctype;
    }

    /**
     * {@inheritdoc}
     */
    public function setCtype($ctype)
    {
        $this->ctype = $ctype;

        return $this;
    }

    /**
     * {@inheritdoc}
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
    public function getLanguageFrom()
    {
        return $this->languageFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageFrom($languageFrom)
    {
        $this->languageFrom = $languageFrom;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguageTo()
    {
        return $this->languageTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageTo($languageTo)
    {
        $this->languageTo = $languageTo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectBriefing()
    {
        return $this->projectBriefing;
    }

    /**
     * {@inheritdoc}
     */
    public function setProjectBriefing($projectBriefing)
    {
        $this->projectBriefing = $projectBriefing;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * {@inheritdoc}
     */
    public function setDocuments(array $documents)
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addDocument(DocumentInterface $document)
    {
        $document->setProject($this);
        $this->documents[] = $document;
    }

    /**
     * {@inheritdoc}
     */
    public function removeDocument(DocumentInterface $document)
    {
        $document->setProject(null);
        $key = array_search($document, $this->documents);

        unset($this->documents[$key]);
    }
}
