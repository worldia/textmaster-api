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
        return [
            ['author', 'Textmaster\Api\Author'],
            ['authors', 'Textmaster\Api\Author'],
            ['billing', 'Textmaster\Api\Billing'],
            ['bundle', 'Textmaster\Api\Bundle'],
            ['bundles', 'Textmaster\Api\Bundle'],
            ['category', 'Textmaster\Api\Category'],
            ['categories', 'Textmaster\Api\Category'],
            ['expertise', 'Textmaster\Api\Expertise'],
            ['expertises', 'Textmaster\Api\Expertise'],
            ['language', 'Textmaster\Api\Language'],
            ['languages', 'Textmaster\Api\Language'],
            ['locale', 'Textmaster\Api\Locale'],
            ['locales', 'Textmaster\Api\Locale'],
            ['project', 'Textmaster\Api\Project'],
            ['projects', 'Textmaster\Api\Project'],
            ['template', 'Textmaster\Api\Template'],
            ['templates', 'Textmaster\Api\Template'],
            ['user', 'Textmaster\Api\User'],
            ['users', 'Textmaster\Api\User'],
        ];
    }

    public function getHttpClientMock(array $methods = [])
    {
        $methods = array_merge(
            ['get', 'post', 'patch', 'put', 'delete', 'request', 'setOption', 'setHeaders', 'authenticate'],
            $methods
        );

        return $this->getMock('Textmaster\HttpClient\HttpClientInterface', $methods);
    }
}
