<?php

namespace Textmaster\Tests\Api\Expertise;

use Textmaster\Tests\Api\TestCase;

class SubExpertiseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllSubExpertises()
    {
        $expectedArray = array (
            array (
                'id' => '561d1b770ed4c03ab4000ea7',
                'name' => 'General',
                'code' => 'general',
                'client_pricing' => 10,
                'client_pricing_in_locale' => 0,
            ),
            array (
                'id' => '561d1b770ed4c03ab4000eaa',
                'name' => 'Banking',
                'code' => 'banking',
                'client_pricing' => 20,
                'client_pricing_in_locale' => 0,
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises/1/sub_expertises')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all(1, 'fr-FR'));
    }

    /**
     * @test
     */
    public function shouldShowSubExpertise()
    {
        $expectedArray = array (
            'id' => '561d1b770ed4c03ab4000e9e',
            'name' => 'General',
            'code' => 'general',
            'client_pricing' => 10,
            'client_pricing_in_locale' => 0,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises/1/sub_expertises/2')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(1, 2, 'fr-FR'));
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Expertise\SubExpertise';
    }
}
