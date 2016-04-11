<?php

namespace Textmaster\Model;

interface ProjectInterface
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
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getCtype();

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
     * @return string
     */
    public function getLanguageFrom();

    /**
     * @return string
     */
    public function getLanguageTo();

    /**
     * @return string
     */
    public function getCategory();

    /**
     * @return string
     */
    public function getProjectBriefing();

    /**
     * @return array
     */
    public function getOptions();
}
