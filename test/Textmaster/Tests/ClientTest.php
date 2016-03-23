<?php

namespace Textmaster\Tests;

use Textmaster\Client;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\BadMethodCallException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Textmaster\HttpClient\HttpClient', $client->getHttpClient());
    }

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
     */
    public function shouldAuthenticateUsingAllGivenParameters()
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('authenticate')
            ->with('key', 'secret');

        $client = new Client($httpClient);
        $client->authenticate('key', 'secret');
    }

    /**
     * @test
     */
    public function shouldClearHeadersLazy()
    {
        $httpClient = $this->getHttpClientMock(array('clearHeaders'));
        $httpClient->expects($this->once())->method('clearHeaders');

        $client = new Client($httpClient);
        $client->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldSetHeadersLaizly()
    {
        $headers = array('header1', 'header2');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())->method('setHeaders')->with($headers);

        $client = new Client($httpClient);
        $client->setHeaders($headers);
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function shouldNotGetMagicApiInstance()
    {
        $client = new Client();
        $client->doNotExist();
    }

    /**
     * @test
     */
    public function shouldSetOption()
    {
        $client = new Client();
        $client->setOption('api_version', 'v1');

        $this->assertEquals($client->getOption('api_version'), 'v1');
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenSettingInvalidOption()
    {
        $client = new Client();
        $client->setOption('unexisting', 'value');
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenGettingInvalidOption()
    {
        $client = new Client();
        $client->getOption('unexisting');
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
