<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Tests\Api;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowInfoAboutCurrentUser()
    {
        $expectedArray = array('id' => 123456);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/users/me')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->me());
    }

    /**
     * @test
     */
    public function shouldGetCallbackApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\User\Callback', $api->callbacks());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\User';
    }
}
