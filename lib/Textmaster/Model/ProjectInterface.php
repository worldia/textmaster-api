<?php

namespace Textmaster\Model;

interface ProjectInterface extends TextMasterObject
{
    const CTYPE_TRANSLATION = 'translation';
    const CTYPE_COPYWRITING = 'copywriting';
    const CTYPE_PROOFREADING = 'proofreading';

    const STATUS_IN_CREATION = 'in_creation';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELED = 'canceled';

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get ctype.
     *
     * @return string
     */
    public function getCtype();

    /**
     * Get allowed activities.
     *
     * @return string
     */
    public function getAllowedCtypes();

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get language from.
     *
     * @return string
     */
    public function getLanguageFrom();

    /**
     * Get language to.
     *
     * @return string
     */
    public function getLanguageTo();

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory();

    /**
     * Get project briefing.
     *
     * @return string
     */
    public function getProjectBriefing();

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Get documents.
     *
     * @return array
     */
    public function getDocuments();

    /**
     * Add a document.
     *
     * @param DocumentInterface $document
     */
    public function addDocument(DocumentInterface $document);

    /**
     * Remove a document.
     *
     * @param DocumentInterface $document
     */
    public function removeDocument(DocumentInterface $document);

    /**
     * @param string $name
     *
     * @return Project
     */
    public function setName($name);

    /**
     * @param string $ctype
     *
     * @return Project
     */
    public function setCtype($ctype);

    /**
     * @param string $status
     *
     * @return Project
     */
    public function setStatus($status);

    /**
     * @param string $languageFrom
     *
     * @return Project
     */
    public function setLanguageFrom($languageFrom);

    /**
     * @param string $languageTo
     *
     * @return Project
     */
    public function setLanguageTo($languageTo);

    /**
     * @param string $category
     *
     * @return Project
     */
    public function setCategory($category);

    /**
     * @param string $projectBriefing
     *
     * @return Project
     */
    public function setProjectBriefing($projectBriefing);

    /**
     * @param array $options
     *
     * @return Project
     */
    public function setOptions($options);
}
