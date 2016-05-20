<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api;

use GuzzleHttp\Psr7\Response;
use Textmaster\Api\AbstractApi;
use Textmaster\HttpClient\HttpClientInterface;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path', array('param1' => 'param1value'), array('header1' => 'header1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->get('/path', array('param1' => 'param1value'), array('header1' => 'header1value')));
    }

    /**
     * @test
     */
    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->post('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('patch')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->patch('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->put('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->delete('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassHEADRequestToClient()
    {
        $expectedArray = array('value');

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('/path', array(), 'HEAD', array(), array('query' => array('param1' => 'param1value')))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->head('/path', array('param1' => 'param1value')));
    }

    protected function getAbstractApiObject($client)
    {
        return new ExposedAbstractApiTestInstance($client);
    }

    /**
     * @param HttpClientInterface $httpClient
     *
     * @return \Textmaster\Client
     */
    protected function getClientMock(HttpClientInterface $httpClient)
    {
        return new \Textmaster\Client($httpClient);
    }

    /**
     * @return \Textmaster\HttpClient\HttpClientInterface
     */
    protected function getHttpMock()
    {
        return $this->getMock('Textmaster\HttpClient\HttpClient', array(), array(array(), $this->getHttpClientMock()));
    }

    protected function getHttpClientMock()
    {
        $mock = $this->getMock('Guzzle\Http\Client', array('send'));
        $mock
            ->expects($this->any())
            ->method('send');

        return $mock;
    }

    protected function getResponse($content)
    {
        $body = \GuzzleHttp\Psr7\stream_for(json_encode($content, true));

        return new Response(200, array('Content-Type' => 'application/json'), $body);
    }
}

class AbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->post($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function postRaw($path, $body, $requestHeaders = array())
    {
        return $this->client->getHttpClient()->post($path, $body, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->patch($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->put($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        return $this->client->getHttpClient()->delete($path, $parameters, $requestHeaders);
    }
}

class ExposedAbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::get($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::post($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::patch($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::put($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::delete($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function head($path, array $parameters = array(), $requestHeaders = array())
    {
        return parent::head($path, $parameters, $requestHeaders);
    }
}
