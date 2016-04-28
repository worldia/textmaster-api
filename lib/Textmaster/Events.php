<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster;

/**
 * Textmaster API events.
 *
 * @link https://www.textmaster.com/documentation#principles-work-flow
 */
final class Events
{
    /**************************************************************************************
     * Document Events                                                                    *
     **************************************************************************************/

    /**
     * Initial status.
     *
     * The document can be edited and is not accessible to the authors yet.
     */
    const DOCUMENT_IN_CREATION = 'textmaster.document.in_creation';

    /**
     * Awaiting author assignment.
     *
     * The document is visible to the authors.
     * Requirements can not be changed unless the document is paused.
     */
    const DOCUMENT_WAITING_ASSIGNMENT = 'textmaster.document.waiting_assignment';

    /**
     * In progress.
     *
     * An author is working on the document.
     */
    const DOCUMENT_IN_PROGRESS = 'textmaster.document.in_progress';

    /**
     * Paused.
     *
     * Client's sole decision.
     * The document is not accessible to the authors.
     */
    const DOCUMENT_PAUSED = 'textmaster.document.paused';

    /**
     * Canceled.
     *
     * Client's sole decision.
     * The document is no longer accessible to the authors and
     * the credits spent are charged back to the client account.
     */
    const DOCUMENT_CANCELED = 'textmaster.document.canceled';

    /**
     * Plagiarism tests.
     *
     * This step is specific to copywriting documents.
     * Textmaster performs a plagiarism detection analysis on the document.
     */
    const DOCUMENT_CHECK_PLAGIARISM = 'textmaster.document.copyscape';

    /**
     * Document verification.
     *
     * Textmaster checks the content of the document (key words, counting words,...).
     */
    const DOCUMENT_CHECK_WORDS = 'textmaster.document.counting_words';

    /**
     * Word count finished.
     *
     * Triggered when a word-counting has finished for document
     * which was created with the 'perform_word_count' option.
     */
    const DOCUMENT_WORDS_COUNTED = 'textmaster.document.word_count_finished';

    /**
     * Quality control.
     *
     * The QC manager is reviewing the document, to approve the quality of the job.
     */
    const DOCUMENT_CHECK_QUALITY = 'textmaster.document.quality_control';

    /**
     * Under review.
     *
     * The document is ready for review by the client.
     */
    const DOCUMENT_IN_REVIEW = 'textmaster.document.in_review';

    /**
     * Incomplete.
     *
     * The author needs to rework the document.
     * Three possible reasons:
     * 1/ The author needs information.
     * 2/ The client requested a revision.
     * 3/ The document did not pass Textmaster's quality control
     */
    const DOCUMENT_INCOMPLETE = 'textmaster.document.incomplete';

    /**
     * Completed.
     *
     * The job is completed and the author is paid.
     */
    const DOCUMENT_COMPLETED = 'textmaster.document.completed';

    /**************************************************************************************
     * Project Events                                                                     *
     **************************************************************************************/

    /**
     * Triggered when project is launched and is ready to be taken by authors.
     * Useful for asynchronous launching.
     */
    const PROJECT_IN_PROGRESS = 'textmaster.project.in_progress';

    /**
     * Get all existing events for documents.
     *
     * @return array
     */
    public static function getDocumentEvents()
    {
        return array(
            self::IN_CREATION,
            self::DOCUMENT_WAITING_ASSIGNMENT,
            self::DOCUMENT_IN_PROGRESS,
            self::DOCUMENT_PAUSED,
            self::DOCUMENT_CANCELED,
            self::DOCUMENT_CHECK_PLAGIARISM,
            self::DOCUMENT_CHECK_WORDS,
            self::DOCUMENT_WORDS_COUNTED,
            self::DOCUMENT_CHECK_QUALITY,
            self::DOCUMENT_IN_REVIEW,
            self::DOCUMENT_INCOMPLETE,
            self::DOCUMENT_COMPLETED,
        );
    }

    /**
     * Get all existing events for projects.
     *
     * @return array
     */
    public static function getProjectEvents()
    {
        return array(
            self::PROJECT_IN_PROGRESS,
        );
    }
}
