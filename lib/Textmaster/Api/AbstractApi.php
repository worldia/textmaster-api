<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Api;

use GuzzleHttp\Psr7\Response;
use Textmaster\Client;
use Textmaster\HttpClient\Message\ResponseMediator;

/**
 * Abstract class for Api classes.
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * The client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Number of items per page.
     *
     * @var null|int
     */
    protected $perPage;

    /**
     * Page parameter for next get request.
     *
     * @var null|int
     */
    protected $page;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (null === $perPage ? $perPage : (int) $perPage);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function setPage($page)
    {
        $this->page = (null === $page ? $page : (int) $page);

        return $this;
    }

    /**
     * Get API client.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function get($path, array $parameters = [], $requestHeaders = [])
    {
        $defaultParams = ['page' => 'page', 'per_page' => 'perPage'];

        foreach ($defaultParams as $snake => $camel) {
            if (isset($this->$camel) && !isset($parameters[$snake])) {
                $parameters[$snake] = $this->$camel;
            }
        }

        $this->page = null;

        $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a HEAD request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     HEAD parameters.
     * @param array  $requestHeaders Request headers.
     *
     * @return Response
     */
    protected function head($path, array $parameters = [], $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->request($path, null, 'HEAD', $requestHeaders, [
            'query' => $parameters,
        ]);

        return $response;
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function post($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->postRaw(
            $path,
            $parameters,
            $requestHeaders
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string $path           Request path.
     * @param string $body           Request body.
     * @param array  $requestHeaders Request headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function postRaw($path, $body, $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $body,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function patch($path, array $parameters = [], $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $parameters,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function put($path, array $parameters = [], $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $parameters,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return \GuzzleHttp\Psr7\Stream|mixed|\Psr\Http\Message\StreamInterface
     */
    protected function delete($path, array $parameters = [], $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $parameters,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }
}
