<?php

namespace Textmaster\Model;

interface DocumentInterface
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
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get project.
     *
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * Set project.
     *
     * @param ProjectInterface $project
     *
     * @return DocumentInterface
     */
    public function setProject(ProjectInterface $project);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle($title);

    /**
     * Get instructions.
     *
     * @return string
     */
    public function getInstructions();

    /**
     * Set instructions.
     *
     * @param string $instructions
     *
     * @return DocumentInterface
     */
    public function setInstructions($instructions);

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get original content.
     *
     * @return string
     */
    public function getOriginalContent();

    /**
     * Get original content.
     *
     * @param string $content
     *
     * @return DocumentInterface
     */
    public function setOriginalContent($content);

    /**
     * @return string
     */
    public function getTranslatedContent();
}
