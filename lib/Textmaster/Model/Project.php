<?php

namespace Textmaster\Model;

class Project extends TextmasterObject implements ProjectInterface
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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
    public function getCtype()
    {
        return $this->ctype;
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
    public function getLanguageFrom()
    {
        return $this->languageFrom;
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
    public function getCategory()
    {
        return $this->category;
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
    public function getOptions()
    {
        return $this->options;
    }
}
