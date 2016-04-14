<?php

namespace Textmaster\Api;

/**
 * Api interface.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
interface ApiInterface
{
    /**
     * Get number of items per page.
     *
     * @return int
     */
    public function getPerPage();

    /**
     * Set number of items per page.
     *
     * @param int $perPage
     *
     * @return ApiInterface
     */
    public function setPerPage($perPage);

    /**
     * Get page.
     *
     * @return int
     */
    public function getPage();

    /**
     * Set page.
     *
     * @param int $page
     *
     * @return ApiInterface
     */
    public function setPage($page);
}
