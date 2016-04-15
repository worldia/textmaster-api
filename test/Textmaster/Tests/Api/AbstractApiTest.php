<?php

namespace Textmaster\Tests\Api;

use Textmaster\Api\AbstractApi;
use Guzzle\Http\Message\Response;
use Guzzle\Http\EntityBody;

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
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->get('/path', array('param1' => 'param1value'), array('header1' => 'header1value')));
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
            ->with('/path', $this->getJsonBody(array('param1' => 'param1value')), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->post('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
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
            ->with('/path', $this->getJsonBody(array('param1' => 'param1value')), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->patch('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
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
            ->with('/path', $this->getJsonBody(array('param1' => 'param1value')), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->put('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
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
            ->with('/path', $this->getJsonBody(array('param1' => 'param1value')), array('option1' => 'option1value'))
            ->will($this->returnValue($this->getResponse($expectedArray)));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->delete('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
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
            ->with('/path', null, 'HEAD', array(), array('query' => array('param1' => 'param1value')))
            ->will($this->returnValue($expectedArray));
        $client = $this->getClientMock();
        $client->setHttpClient($httpClient);

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->head('/path', array('param1' => 'param1value')));
    }

    protected function getAbstractApiObject($client)
    {
        return new ExposedAbstractApiTestInstance($client);
    }

    /**
     * @return \Textmaster\Client
     */
    protected function getClientMock()
    {
        return new \Textmaster\Client($this->getHttpMock());
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

    protected function getJsonBody($parameters)
    {
        return json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }

    protected function getResponse($content)
    {
        $body = EntityBody::factory(json_encode($content, true));

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
