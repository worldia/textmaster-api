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

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    protected function getApiMock()
    {
        $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $httpClient
            ->expects($this->any())
            ->method('send');

        $mock = $this->getMock('Textmaster\HttpClient\HttpClient', array(), array(array(), $httpClient));

        $client = new \Textmaster\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
