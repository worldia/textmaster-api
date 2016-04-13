<?php

namespace Textmaster\Api;

class ResultPagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldInitialize()
    {
        $expectedArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => null,
            'previous_page' => null,
        );

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($expectedArray);

        $resultPager = new \Textmaster\ResultPager($clientMock);
        $this->assertEquals(array(), $resultPager->getPagination());

        $resultPager->initialize($apiMock, 'all');
        $this->assertEquals($expectedArray, $resultPager->getPagination());
    }

    /**
     * @test
     */
    public function shouldHaveNext()
    {
        $expectedArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => 'http://next.page.com',
            'previous_page' => null,
        );

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($expectedArray);

        $resultPager = new \Textmaster\ResultPager($clientMock);

        $this->assertFalse($resultPager->hasNext());
        $resultPager->initialize($apiMock, 'all');
        $this->assertTrue($resultPager->hasNext());
    }

    /**
     * @test
     */
    public function shouldHavePrevious()
    {
        $expectedArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => 'http://next.page.com',
            'previous_page' => 'http://previous.page.com',
        );

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($expectedArray);

        $resultPager = new \Textmaster\ResultPager($clientMock);

        $this->assertFalse($resultPager->hasPrevious());
        $resultPager->initialize($apiMock, 'all');
        $this->assertTrue($resultPager->hasPrevious());
    }

    /**
     * @test
     */
    public function shouldFetchNext()
    {
        $initializeArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => 'http://next.page.com',
            'previous_page' => null,
        );

        $expectedArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => null,
            'previous_page' => 'http://previous.page.com',
        );

        $responseMock = $this->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock->method('getBody')
            ->willReturn($expectedArray);

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $httpClientMock->method('get')
            ->willReturn($responseMock);

        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($initializeArray);

        $resultPager = new \Textmaster\ResultPager($clientMock);
        $resultPager->initialize($apiMock, 'all');
        $resultPager->fetchNext();

        $this->assertEquals($expectedArray, $resultPager->getPagination());
    }
    /**
     * @test
     */
    public function shouldFetchPrevious()
    {
        $initializeArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => null,
            'previous_page' => 'http://previous.page.com',
        );

        $expectedArray = array(
            'projects' => array(
                array('id' => 1, 'name' => 'Test project 1'),
                array('id' => 2, 'name' => 'Test project 2'),
            ),
            'next_page' => 'http://next.page.com',
            'previous_page' => null,

        );

        $responseMock = $this->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock->method('getBody')
            ->willReturn($expectedArray);

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $httpClientMock->method('get')
            ->willReturn($responseMock);

        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($initializeArray);

        $resultPager = new \Textmaster\ResultPager($clientMock);
        $resultPager->initialize($apiMock, 'all');
        $resultPager->fetchPrevious();

        $this->assertEquals($expectedArray, $resultPager->getPagination());
    }
}
