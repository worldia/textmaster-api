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

use Textmaster\Api\ApiInterface;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\HttpClient\HttpClient;
use Textmaster\HttpClient\HttpClientInterface;

/**
 * PHP Textmaster client.
 *
 * @method Api\Author author()
 * @method Api\Author authors()
 * @method Api\Billing billing()
 * @method Api\Bundle bundle()
 * @method Api\Bundle bundles()
 * @method Api\Category category()
 * @method Api\Category categories()
 * @method Api\Expertise expertise()
 * @method Api\Expertise expertises()
 * @method Api\Language language()
 * @method Api\Language languages()
 * @method Api\Locale locale()
 * @method Api\Locale locales()
 * @method Api\Project project()
 * @method Api\Project projects()
 * @method Api\Template template()
 * @method Api\Template templates()
 * @method Api\User user()
 * @method Api\User users()
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Client
{
    /**
     * @var array
     */
    private $options = array(
        'base_url' => 'http://api.textmaster.com/%s/clients',
        'api_version' => 'v1',
        'sandbox' => false,
        'user_agent' => 'php-textmaster-api (http://github.com/cdaguerre/php-textmaster-api)',
        'timeout' => 10,
        'cache_dir' => null,
    );

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * Instantiate a new Textmaster client.
     *
     * @param null|HttpClientInterface $httpClient Textmaster http client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($name)
    {
        switch ($name) {
            case 'author':
            case 'authors':
                $api = new Api\Author($this);
                break;
            case 'billing':
                $api = new Api\Billing($this);
                break;
            case 'bundle':
            case 'bundles':
                $api = new Api\Bundle($this);
                break;
            case 'category':
            case 'categories':
                $api = new Api\Category($this);
                break;
            case 'expertise':
            case 'expertises':
                $api = new Api\Expertise($this);
                break;
            case 'language':
            case 'languages':
                $api = new Api\Language($this);
                break;
            case 'locale':
            case 'locales':
                $api = new Api\Locale($this);
                break;
            case 'project':
            case 'projects':
                $api = new Api\Project($this);
                break;
            case 'template':
            case 'templates':
                $api = new Api\Template($this);
                break;
            case 'user':
            case 'users':
                $api = new Api\User($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string $key    Textmaster api key
     * @param string $secret Textmaster secret
     */
    public function authenticate($key, $secret)
    {
        $this->getHttpClient()->authenticate($key, $secret);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient($this->options);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers.
     */
    public function clearHeaders()
    {
        $this->getHttpClient()->clearHeaders();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->getHttpClient()->setHeaders($headers);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getOption($name)
    {
        $this->validateOptionExistence($name);

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        $this->validateOptionExistence($name);

        $this->options[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @throws BadMethodCallException
     *
     * @return ApiInterface
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @param string $name
     */
    private function validateOptionExistence($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }
    }
}
