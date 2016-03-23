<?php

namespace Textmaster\Tests\Api;

class ExpertiseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllExpertises()
    {
        $expectedArray = array(
            array(
                'id' => '551290294d61630e52120000',
                'name' => 'Finance',
                'client_pricing' => 10,
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('copywriting'));
    }

    /**
     * @test
     */
    public function shouldShowAllExpertisesLocalized()
    {
        $expectedArray = array(
            array(
                'id' => '551290294d61630e52120000',
                'name' => 'Finance',
                'client_pricing' => 10,
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/expertises')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all('copywriting', 'fr-FR'));
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
