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
        $httpClientMock = $this->createMock('Textmaster\HttpClient\HttpClientInterface');

        $client = new \Textmaster\Client($httpClientMock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client])
            ->getMock();
    }
}
