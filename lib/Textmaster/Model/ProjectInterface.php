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

use Pagerfanta\Pagerfanta;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\ObjectImmutableException;
use Textmaster\Exception\UnexpectedTypeException;

interface ProjectInterface extends AbstractObjectInterface
{
    const ACTIVITY_TRANSLATION = 'translation';
    const ACTIVITY_COPYWRITING = 'copywriting';
    const ACTIVITY_PROOFREADING = 'proofreading';

    const STATUS_IN_CREATION = 'in_creation';
    const STATUS_MEMORY_COMPLETED = 'tm_completed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELED = 'canceled';

    const CALLBACK_PROJECT_IN_PROGRESS = 'project_in_progress';
    const CALLBACK_PROJECT_MEMORY_COMPLETED = 'project_tm_completed';

    /**
     * Save the project.
     *
     * @return ProjectInterface
     */
    public function save();

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
     * Get list of all allowed callbacks.
     *
     * @return array
     */
    public static function getAllowedCallbacks();

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
     * @return ProjectInterface
     */
    public function setCallback(array $callback);

    /**
     * Get work template value.
     *
     * @return array
     */
    public function getWorkTemplate();

    /**
     * Set work template value.
     *
     * @param string $template
     *
     * @return ProjectInterface
     */
    public function setWorkTemplate($template);

    /**
     * Get documents.
     *
     * @param array $where criteria to filter documents.
     * @param array $order criteria to order documents.
     *
     * @return Pagerfanta
     */
    public function getDocuments(array $where = [], array $order = []);

    /**
     * Create a document.
     *
     * @return DocumentInterface
     *
     * @throws BadMethodCallException If the project has no id.
     */
    public function createDocument();

    /**
     * Add documents.
     *
     * @param array|DocumentInterface[] $documents
     *
     * @return ProjectInterface
     *
     * @throws UnexpectedTypeException  If one of array values is not a DocumentInterface
     * @throws InvalidArgumentException If a given document relates to a different project.
     */
    public function addDocuments(array $documents);

    /**
     * Launch the project asynchronously.
     *
     * @return ProjectInterface
     */
    public function launch();
}
