<?php

namespace Textmaster\Tests\Api;

class TemplateTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllTemplates()
    {
        $expectedArray = array(
            'work_templates' => array(
                array(
                    'name' => '1_title_1_paragraph',
                    'description' => null,
                    'image_preview_path' => null,
                    'ctype' => 'public',
                ),
                array(
                    'name' => '2_paragraphs',
                    'description' => null,
                    'image_preview_path' => null,
                    'ctype' => 'public',
                ),
            ),
            'total_pages' => 0,
            'count' => 2,
            'page' => 1,
            'per_page' => 20,
            'previous_page' => null,
            'next_page' => null,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/work_templates')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldFindTemplateByName()
    {
        $expectedArray = array(
            'name' => '2_paragraphs',
            'description' => null,
            'image_preview_path' => null,
            'ctype' => 'public',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/work_templates/2_paragraphs')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->byName('2_paragraphs'));
    }


    protected function getApiClass()
    {
        return 'Textmaster\Api\Template';
    }
}
