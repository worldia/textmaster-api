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

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Instantiate a new Textmaster client.
     *
     * @param HttpClientInterface           $httpClient Textmaster http client
     * @param null|EventDispatcherInterface $dispatcher Event dispatcher
     */
    public function __construct(HttpClientInterface $httpClient, EventDispatcherInterface $dispatcher = null)
    {
        $this->httpClient = $httpClient;
        $this->dispatcher = $dispatcher;
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
        $name = Inflector::singularize($name);
        $apis = [
            'author', 'billing', 'bundle', 'category', 'expertise', 'language', 'locale', 'project', 'template', 'user',
        ];

        if (!in_array($name, $apis, true)) {
            throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        $class = sprintf('Textmaster\Api\%s', ucfirst($name));

        return new $class($this);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        if (null === $this->dispatcher) {
            $this->dispatcher = new EventDispatcher();
        }

        return $this->dispatcher;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string $name
     * @param string $args
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
}
