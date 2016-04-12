<?php

namespace Textmaster\HttpClient;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Textmaster\Exception\ErrorException;
use Textmaster\Exception\RuntimeException;
use Textmaster\HttpClient\Listener\AuthListener;
use Textmaster\HttpClient\Listener\ErrorListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Performs requests on Textmaster API. API documentation should be self-explanatory.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    protected $options = array(
        'base_url' => 'http://api.textmaster.com/%s/clients',

        'user_agent' => 'php-textmaster-api (http://github.com/cdaguerre/php-textmaster-api)',
        'timeout' => 10,

        'api_version' => 'v1',

        'cache_dir' => null,
    );

    protected $headers = array();

    private $lastResponse;
    private $lastRequest;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $this->options = array_merge($this->options, $options);
        $client = $client ?: new GuzzleClient(
            sprintf($this->options['base_url'], $this->options['api_version']),
            $this->options
        );
        $this->client = $client;

        $this->addListener('request.error', array(new ErrorListener($this->options), 'onRequestError'));
        $this->clearHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clears used headers.
     */
    public function clearHeaders()
    {
        $this->headers = array(
            'User-Agent' => sprintf('%s', $this->options['user_agent']),
        );
    }

    /**
     * @param string $eventName
     */
    public function addListener($eventName, $listener)
    {
        $this->client->getEventDispatcher()->addListener($eventName, $listener);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->client->addSubscriber($subscriber);
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'PATCH', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'DELETE', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, $body, array $headers = array())
    {
        return $this->request($path, $body, 'PUT', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        $request = $this->createRequest($httpMethod, $path, $body, $headers, $options);

        try {
            /** @var \Guzzle\Http\Message\Response $response */
            $response = $this->client->send($request);
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
     * {@inheritdoc}
     */
    public function authenticate($key, $secret)
    {
        $this->addListener('request.before_send', array(
            new AuthListener($key, $secret), 'onRequestBeforeSend',
        ));
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
     * @param string $httpMethod
     * @param string $path
     */
    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        return $this->client->createRequest(
            $httpMethod,
            $path,
            array_merge($this->headers, $headers),
            $body,
            $options
        );
    }
}
