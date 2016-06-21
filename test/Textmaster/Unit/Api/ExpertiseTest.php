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

class ExpertiseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllExpertises()
    {
        $expectedArray = [
            [
                'id' => '551290294d61630e52120000',
                'name' => 'Finance',
                'client_pricing' => 10,
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all('copywriting'));
    }

    /**
     * @test
     */
    public function shouldShowAllExpertisesLocalized()
    {
        $expectedArray = [
            [
                'id' => '551290294d61630e52120000',
                'name' => 'Finance',
                'client_pricing' => 10,
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all('copywriting', 'fr-FR'));
    }

    /**
     * @test
     */
    public function shouldGetSubExpertiseApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\Expertise\SubExpertise', $api->subExpertises());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Expertise';
    }
}
