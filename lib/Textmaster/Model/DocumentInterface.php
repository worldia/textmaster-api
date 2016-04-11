<?php

namespace Textmaster\Model;

interface DocumentInterface extends TextMasterObject
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
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getOriginalContent();

    /**
     * @return string
     */
    public function getTranslatedContent();

    /**
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle($title);

    /**
     * @param string $status
     *
     * @return DocumentInterface
     */
    public function setStatus($status);

    /**
     * @param string $originalContent
     *
     * @return DocumentInterface
     */
    public function setOriginalContent($originalContent);

    /**
     * @param string $translatedContent
     *
     * @return DocumentInterface
     */
    public function setTranslatedContent($translatedContent);

    /**
     * @param ProjectInterface $project
     *
     * @return DocumentInterface
     */
    public function setProject(ProjectInterface $project);
}
