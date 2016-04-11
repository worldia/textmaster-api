<?php

namespace Textmaster\Model;

interface DocumentInterface extends TextmasterObject
{
    const STATUS_IN_CREATION = 'in_creation';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_WAITING_ASSIGNMENT = 'waiting_assignment';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COPYSCAPE = 'copyscape';
    const STATUS_COUNTING_WORDS = 'counting_words';
    const STATUS_QUALITY = 'quality_control';

    /**
     * @return DocumentInterface
     */
    public function getId();

    /**
     * @param string $id
     *
     * @return DocumentInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     *
     * @return DocumentInterface
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getOriginalContent();

    /**
     * @param string $originalContent
     *
     * @return DocumentInterface
     */
    public function setOriginalContent($originalContent);

    /**
     * @return string
     */
    public function getTranslatedContent();

    /**
     * @param string $translatedContent
     *
     * @return DocumentInterface
     */
    public function setTranslatedContent($translatedContent);

    /**
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * @param ProjectInterface $project
     *
     * @return DocumentInterface
     */
    public function setProject(ProjectInterface $project = null);
}
