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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Textmaster\Api\AbstractApi;
use Textmaster\HttpClient\HttpClient;
use Textmaster\HttpClient\HttpClientInterface;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with('/path', ['param1' => 'param1value'], ['header1' => 'header1value'])
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->get('/path', ['param1' => 'param1value'], ['header1' => 'header1value']));
    }

    /**
     * @test
     */
    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with('/path', ['param1' => 'param1value'], ['option1' => 'option1value'])
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->post('/path', ['param1' => 'param1value'], ['option1' => 'option1value']));
    }

    /**
     * @test
     */
    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('patch')
            ->with('/path', ['param1' => 'param1value'], ['option1' => 'option1value'])
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->patch('/path', ['param1' => 'param1value'], ['option1' => 'option1value']));
    }

    /**
     * @test
     */
    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with('/path', ['param1' => 'param1value'], ['option1' => 'option1value'])
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->put('/path', ['param1' => 'param1value'], ['option1' => 'option1value']));
    }

    /**
     * @test
     */
    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with('/path', ['param1' => 'param1value'], ['option1' => 'option1value'])
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->delete('/path', ['param1' => 'param1value'], ['option1' => 'option1value']));
    }

    /**
     * @test
     */
    public function shouldPassHEADRequestToClient()
    {
        $expectedArray = ['value'];

        $httpClient = $this->getHttpMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('/path', [], 'HEAD', [], ['query' => ['param1' => 'param1value']])
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertSame($expectedArray, $api->head('/path', ['param1' => 'param1value']));
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
     * @return \PHPUnit_Framework_MockObject_MockObject|HttpClientInterface
     */
    protected function getHttpMock()
    {
        return $this->createMock(HttpClient::class);
    }

    protected function getHttpClientMock()
    {
        $mock = $this->createPartialMock(Client::class, ['send']);
        $mock
            ->expects($this->any())
            ->method('send');

        return $mock;
    }

    protected function getResponse($content)
    {
        $body = \GuzzleHttp\Psr7\stream_for(json_encode($content, true));

        return new Response(200, ['Content-Type' => 'application/json'], $body);
    }
}

class AbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->client->getHttpClient()->post($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function postRaw($path, array $body, $requestHeaders = [])
    {
        return $this->client->getHttpClient()->post($path, $body, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->client->getHttpClient()->patch($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->client->getHttpClient()->put($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->client->getHttpClient()->delete($path, $parameters, $requestHeaders);
    }
}

class ExposedAbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::get($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::post($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::patch($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::put($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::delete($path, $parameters, $requestHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function head($path, array $parameters = [], $requestHeaders = [])
    {
        return parent::head($path, $parameters, $requestHeaders);
    }
}
