<?php

namespace Textmaster;

use Textmaster\Api\ApiInterface;

interface ResultPagerInterface
{
    const NEXT_PAGE = 'next_page';
    const PREVIOUS_PAGE = 'previous_page';

    /**
     * @return null|array pagination result of last request
     */
    public function getPagination();

    /**
     * Initialize the pager to fill in the pagination.
     *
     * @param ApiInterface $api
     * @param string       $method
     * @param array        $parameters
     */
    public function initialize(ApiInterface $api, $method, array $parameters = array());

    /**
     * Check to determine the availability of a next page.
     *
     * @return bool
     */
    public function hasNext();

    /**
     * Check to determine the availability of a previous page.
     *
     * @return bool
     */
    public function hasPrevious();

    /**
     * Fetch the next page.
     *
     * @return array
     */
    public function fetchNext();

    /**
     * Fetch the previous page.
     *
     * @return array
     */
    public function fetchPrevious();
}
