<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Textmaster\Exception\ErrorException;
use Textmaster\Exception\RuntimeException;

/**
 * Performs requests on Textmaster API. API documentation should be self-explanatory.
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [
        'base_uri' => 'http://api.textmaster.com/%s/clients',
        'api_version' => 'v1',
        'user_agent' => 'textmaster-api (http://github.com/worldia/textmaster-api)',
        'timeout' => 10,
    ];

    /**
     * @var ResponseInterface
     */
    private $lastResponse;

    /**
     * @var RequestInterface
     */
    private $lastRequest;

    /**
     * HttpClient constructor.
     *
     * @param string $key
     * @param string $secret
     * @param array  $options
     */
    public function __construct($key, $secret, array $options = [])
    {
        $date = new \DateTime('now', new \DateTimeZone('UTC'));

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($key, $date, $secret) {
            return $request
                ->withHeader('Apikey', $key)
                ->withHeader('Date', $date->format('Y-m-d H:i:s'))
                ->withHeader('Signature', sha1($secret.$date->format('Y-m-d H:i:s')))
            ;
        }));

        $this->options = array_merge($this->options, $options, ['handler' => $stack]);
        $this->options['base_uri'] = sprintf($this->options['base_uri'], $this->options['api_version']);

        $this->client = new Client($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = [], array $headers = [])
    {
        return $this->request($path, null, 'GET', $headers, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $body = [], array $headers = [])
    {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $body = [], array $headers = [])
    {
        return $this->request($path, $body, 'PATCH', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $body = [], array $headers = [])
    {
        return $this->request($path, $body, 'DELETE', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $body = [], array $headers = [])
    {
        return $this->request($path, $body, 'PUT', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, array $body = [], $httpMethod = 'GET', array $headers = [], array $parameters = [])
    {
        $options = [];
        if (null !== $body) {
            $options[RequestOptions::JSON] = $body;
            $options['curl']['body_as_string'] = true;
        }
        if (!empty($parameters)) {
            $options[RequestOptions::QUERY] = $parameters;
        }

        $request = $this->createRequest($httpMethod, $path, $headers);
        try {
            /** @var Response $response */
            $response = $this->client->send($request, $options);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage(), $e->getCode(), $e);
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        $this->lastRequest = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * @return Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Create a request with the given parameters.
     *
     * @param string $httpMethod
     * @param string $path
     * @param array  $headers
     *
     * @return RequestInterface
     */
    protected function createRequest($httpMethod, $path, array $headers = [])
    {
        return new Request($httpMethod, $this->getFinalPath($path), $headers);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function getFinalPath($path)
    {
        return $this->client->getConfig('base_uri')->getPath().'/'.$path;
    }
}
