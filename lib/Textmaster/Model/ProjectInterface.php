<?php

namespace Textmaster\Model;

interface ProjectInterface extends TextmasterObject
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
     * @return string
     */
    public function getId();
    /**
     * @param string $id
     *
     * @return ProjectInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return ProjectInterface
     */
    public function setName($name);
    /**
     * @return string
     */
    public function getCtype();

    /**
     * @param string $ctype
     *
     * @return ProjectInterface
     */
    public function setCtype($ctype);

    /**
     * Get allowed values for ctype.
     *
     * @return array
     */
    public function getAllowedCtypes();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     *
     * @return ProjectInterface
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getLanguageFrom();
    /**
     * @param string $languageFrom
     *
     * @return ProjectInterface
     */
    public function setLanguageFrom($languageFrom);

    /**
     * @return string
     */
    public function getLanguageTo();

    /**
     * @param string $languageTo
     *
     * @return ProjectInterface
     */
    public function setLanguageTo($languageTo);

    /**
     * @return string
     */
    public function getCategory();
    /**
     * @param string $category
     *
     * @return ProjectInterface
     */
    public function setCategory($category);

    /**
     * @return string
     */
    public function getProjectBriefing();

    /**
     * @param string $projectBriefing
     *
     * @return ProjectInterface
     */
    public function setProjectBriefing($projectBriefing);

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     *
     * @return ProjectInterface
     */
    public function setOptions($options);

    /**
     * @return array
     */
    public function getDocuments();

    /**
     * @param array $documents
     *
     * @return ProjectInterface
     */
    public function setDocuments(array $documents);

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
}
