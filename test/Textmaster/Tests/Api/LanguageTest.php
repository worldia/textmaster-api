<?php

namespace Textmaster\Tests\Api;

class LanguageTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllLanguages()
    {
        $expectedArray = array(
            'languages' => array(
                array('code' => 'ar-sa', 'value' => 'Arabic (Modern Standard)'),
                array('code' => 'bg-bg', 'value' => 'Bulgarian'),
                array('code' => 'bs-ba', 'value' => 'Bosnian'),
                array('code' => 'cs-cz', 'value' => 'Czech'),
                array('code' => 'da-dk', 'value' => 'Danish'),
                array('code' => 'de-de', 'value' => 'German'),
                array('code' => 'el-gr', 'value' => 'Greek'),
                array('code' => 'en-gb', 'value' => 'English (UK)'),
                array('code' => 'en-us', 'value' => 'English (US)'),
                array('code' => 'es-es', 'value' => 'Spanish'),
                array('code' => 'fi-fi', 'value' => 'Finnish'),
                array('code' => 'fr-fr', 'value' => 'French'),
                array('code' => 'hr-hr', 'value' => 'Croatian'),
                array('code' => 'hu-hu', 'value' => 'Hungarian'),
                array('code' => 'it-it', 'value' => 'Italian'),
                array('code' => 'ja-jp', 'value' => 'Japanese'),
                array('code' => 'ko-kr', 'value' => 'Korean'),
                array('code' => 'nl-be', 'value' => 'Flemish (Belgium)'),
                array('code' => 'nl-nl', 'value' => 'Dutch'),
                array('code' => 'no-no', 'value' => 'Norwegian'),
                array('code' => 'pl-pl', 'value' => 'Polish'),
                array('code' => 'pt-br', 'value' => 'Portuguese (Brazil)'),
                array('code' => 'pt-pt', 'value' => 'Portuguese (Portugal)'),
                array('code' => 'ro-ro', 'value' => 'Romanian'),
                array('code' => 'ru-ru', 'value' => 'Russian'),
                array('code' => 'sk-sk', 'value' => 'Slovak'),
                array('code' => 'sl-si', 'value' => 'Slovenian'),
                array('code' => 'sr-rs', 'value' => 'Serbian'),
                array('code' => 'sv-se', 'value' => 'Swedish'),
                array('code' => 'tr-tr', 'value' => 'Turkish'),
                array('code' => 'zh-cn', 'value' => 'Chinese (Mandarin Simplified)'),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/languages')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowAllLanguageLevels()
    {
        $expectedArray = array(
            'language_levels' => array(
                array('name' => 'regular'),
                array('name' => 'premium'),
                array('name' => 'enterprise'),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/language_levels')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->levels());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Language';
    }
}
