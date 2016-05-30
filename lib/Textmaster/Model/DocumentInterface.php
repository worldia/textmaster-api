<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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

    const SATISFACTION_NEUTRAL = 'neutral';
    const SATISFACTION_POSITIVE = 'positive';
    const SATISFACTION_NEGATIVE = 'negative';

    const TYPE_STANDARD = 'standard';
    const TYPE_KEY_VALUE = 'key_value';

    const WORD_COUNT_RULE_PERCENTAGE = 0;
    const WORD_COUNT_RULE_MIN = 1;
    const WORD_COUNT_RULE_MAX = 2;

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
     * @return string|array
     */
    public function getOriginalContent();

    /**
     * Get original content.
     *
     * @param string|array $content
     *
     * @return DocumentInterface
     */
    public function setOriginalContent($content);

    /**
     * Get type.
     *
     * @return string
     */
    public function getType();

    /**
     * Get translated content.
     *
     * @return string|array
     */
    public function getTranslatedContent();

    /**
     * Get word count.
     *
     * @return int
     */
    public function getWordCount();

    /**
     * Get API callback values.
     *
     * @return array
     */
    public function getCallback();

    /**
     * Set API callback values.
     *
     * @param array $callback
     *
     * @return DocumentInterface
     */
    public function setCallback(array $callback);

    /**
     * Get custom data.
     *
     * @param string $key To retrieve a specific key
     *
     * @return mixed
     */
    public function getCustomData($key = null);

    /**
     * Set custom data.
     *
     * @param mixed  $customData
     * @param string $key
     *
     * @return DocumentInterface
     */
    public function setCustomData($customData, $key = null);

    /**
     * Complete the document.
     *
     * @param string $satisfaction
     * @param string $message
     *
     * @return DocumentInterface
     */
    public function complete($satisfaction = null, $message = null);

    /**
     * Ask for a revision on the document.
     *
     * @param string $message
     *
     * @return DocumentInterface
     */
    public function reject($message);

    /**
     * Get allowed status.
     *
     * @return array
     */
    public static function getAllowedStatus();

    /**
     * Get allowed satisfaction.
     *
     * @return array
     */
    public static function getAllowedSatisfaction();
}
