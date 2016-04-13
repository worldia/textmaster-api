<?php

namespace Textmaster;

use Textmaster\Api\ApiInterface;
use Textmaster\HttpClient\Message\ResponseMediator;

class ResultPager implements ResultPagerInterface
{
    /**
     * @var array
     */
    protected $pagination = array();

    /**
     * @var Client
     */
    protected $client;

    /**
     * ResultPager constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ApiInterface $api, $method, array $parameters = array())
    {
        /** @var array $pagination */
        $pagination = call_user_func_array(array($api, $method), $parameters);
        $this->pagination = $pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNext()
    {
        return $this->has(self::NEXT_PAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrevious()
    {
        return $this->has(self::PREVIOUS_PAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchNext()
    {
        $this->get(self::NEXT_PAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchPrevious()
    {
        $this->get(self::PREVIOUS_PAGE);
    }

    /**
     * Check if the given key exists in pagination.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function has($key)
    {
        return !empty($this->pagination) && null !== $this->pagination[$key];
    }

    /**
     * Fetch the given page in pagination.
     *
     * @param string $key
     */
    protected function get($key)
    {
        if ($this->has($key)) {
            /** @var array $pagination */
            $pagination = ResponseMediator::getContent($this->client->getHttpClient()->get($this->pagination[$key]));
            $this->pagination = $pagination;
        }
    }
}
