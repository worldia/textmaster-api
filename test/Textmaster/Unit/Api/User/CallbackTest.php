<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api\User;

use Textmaster\Unit\Api\TestCase;

class CallbackTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSetCallback()
    {
        $expectedArray = ['id' => 1];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/users/1')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->set(1, 'waiting_assignment', 'http://www.callbackurl.com', 'json'));
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenSettingCallbackWIthInvalidEvent()
    {
        $this->getApiMock()->set(1, 'invalid_event', 'http://www.callbackurl.com', 'json');
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenSettingCallbackWIthInvalidFormat()
    {
        $this->getApiMock()->set(1, 'waiting_assignment', 'http://www.callbackurl.com', 'html');
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\User\Callback';
    }
}
