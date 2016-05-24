<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit;

use Textmaster\Client;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf('Textmaster\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client($this->getHttpClientMock());
        $client->api('do_not_exist');
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function shouldNotGetMagicApiInstance()
    {
        $client = new Client($this->getHttpClientMock());
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return array(
            array('author', 'Textmaster\Api\Author'),
            array('authors', 'Textmaster\Api\Author'),
            array('billing', 'Textmaster\Api\Billing'),
            array('bundle', 'Textmaster\Api\Bundle'),
            array('bundles', 'Textmaster\Api\Bundle'),
            array('category', 'Textmaster\Api\Category'),
            array('categories', 'Textmaster\Api\Category'),
            array('expertise', 'Textmaster\Api\Expertise'),
            array('expertises', 'Textmaster\Api\Expertise'),
            array('language', 'Textmaster\Api\Language'),
            array('languages', 'Textmaster\Api\Language'),
            array('locale', 'Textmaster\Api\Locale'),
            array('locales', 'Textmaster\Api\Locale'),
            array('project', 'Textmaster\Api\Project'),
            array('projects', 'Textmaster\Api\Project'),
            array('template', 'Textmaster\Api\Template'),
            array('templates', 'Textmaster\Api\Template'),
            array('user', 'Textmaster\Api\User'),
            array('users', 'Textmaster\Api\User'),
        );
    }

    public function getHttpClientMock(array $methods = array())
    {
        $methods = array_merge(
            array('get', 'post', 'patch', 'put', 'delete', 'request', 'setOption', 'setHeaders', 'authenticate'),
            $methods
        );

        return $this->getMock('Textmaster\HttpClient\HttpClientInterface', $methods);
    }
}
