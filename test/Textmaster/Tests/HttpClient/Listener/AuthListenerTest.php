<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Tests\HttpClient\Listener;

use Textmaster\HttpClient\Listener\AuthListener;

class AuthListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSetSignature()
    {
        $expected = '3db3e8aaafea142063fbf0ad50db8705623817f3';

        $key = 'kh4C2gynMQIz';
        $secret = 'TrXEQGHC9vQz';
        $date = new \DateTime('2011-12-14 11:18:52');

        $request = new \Guzzle\Http\Message\Request('www.textmaster.com', 'GET');

        $listener = new AuthListener($key, $secret, $date);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertSame($expected, $request->getHeader('SIGNATURE')->__toString());
    }

    private function getEventMock($request = null)
    {
        $mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

        if ($request) {
            $mock->expects($this->any())
                ->method('offsetGet')
                ->will($this->returnValue($request));
        }

        return $mock;
    }
}
