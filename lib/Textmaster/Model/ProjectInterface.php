<?php

namespace Textmaster\Model;

use Pagerfanta\Pagerfanta;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\ObjectImmutableException;

interface ProjectInterface
{
    const ACTIVITY_TRANSLATION = 'translation';
    const ACTIVITY_COPYWRITING = 'copywriting';
    const ACTIVITY_PROOFREADING = 'proofreading';

    const STATUS_IN_CREATION = 'in_creation';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELED = 'canceled';

    /**
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setName($name);

    /**
     * Get list of all allowed activities.
     *
     * @return array
     */
    public static function getAllowedActivities();

    /**
     * Get activity type.
     *
     * @return string
     */
    public function getActivity();

    /**
     * Set activity type.
     *
     * @param string $type
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setActivity($type);

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get source language.
     *
     * @return string
     */
    public function getLanguageFrom();

    /**
     * Set source language.
     *
     * @param string $language
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setLanguageFrom($language);

    /**
     * Get destination language.
     *
     * @return string
     */
    public function getLanguageTo();

    /**
     * Set destination language.
     *
     * @param string $language
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setLanguageTo($language);

    /**
     * Get Textmaster content category.
     *
     * @return string
     */
    public function getCategory();

    /**
     * Set Textmaster content category.
     *
     * @param string $code One of the Textmaster category codes, refer https://fr.textmaster.com/documentation#public-listing-categories
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setCategory($code);

    /**
     * Get briefing.
     *
     * @return string
     */
    public function getBriefing();

    /**
     * Set briefing.
     *
     * @param string $briefing
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setBriefing($briefing);

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set options.
     *
     * @param array $options
     *
     * @return ProjectInterface
     *
     * @throws ObjectImmutableException If project was already launched
     */
    public function setOptions(array $options);

    /**
     * Get documents.
     *
     * @param array $where criteria to filter documents.
     * @param array $order criteria to order documents.
     *
     * @return Pagerfanta
     */
    public function getDocuments(array $where = array(), array $order = array());

    /**
     * Create a document.
     *
     * @return DocumentInterface
     *
     * @throws BadMethodCallException If the project has no id.
     */
    public function createDocument();

    /**
     * Launch the project asynchronously.
     *
     * @return ProjectInterface
     */
    public function launch();
}
