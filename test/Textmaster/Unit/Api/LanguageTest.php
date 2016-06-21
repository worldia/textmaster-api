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

class LanguageTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllLanguages()
    {
        $expectedArray = [
            'languages' => [
                ['code' => 'ar-sa', 'value' => 'Arabic (Modern Standard)'],
                ['code' => 'bg-bg', 'value' => 'Bulgarian'],
                ['code' => 'bs-ba', 'value' => 'Bosnian'],
                ['code' => 'cs-cz', 'value' => 'Czech'],
                ['code' => 'da-dk', 'value' => 'Danish'],
                ['code' => 'de-de', 'value' => 'German'],
                ['code' => 'el-gr', 'value' => 'Greek'],
                ['code' => 'en-gb', 'value' => 'English (UK)'],
                ['code' => 'en-us', 'value' => 'English (US)'],
                ['code' => 'es-es', 'value' => 'Spanish'],
                ['code' => 'fi-fi', 'value' => 'Finnish'],
                ['code' => 'fr-fr', 'value' => 'French'],
                ['code' => 'hr-hr', 'value' => 'Croatian'],
                ['code' => 'hu-hu', 'value' => 'Hungarian'],
                ['code' => 'it-it', 'value' => 'Italian'],
                ['code' => 'ja-jp', 'value' => 'Japanese'],
                ['code' => 'ko-kr', 'value' => 'Korean'],
                ['code' => 'nl-be', 'value' => 'Flemish (Belgium)'],
                ['code' => 'nl-nl', 'value' => 'Dutch'],
                ['code' => 'no-no', 'value' => 'Norwegian'],
                ['code' => 'pl-pl', 'value' => 'Polish'],
                ['code' => 'pt-br', 'value' => 'Portuguese (Brazil)'],
                ['code' => 'pt-pt', 'value' => 'Portuguese (Portugal)'],
                ['code' => 'ro-ro', 'value' => 'Romanian'],
                ['code' => 'ru-ru', 'value' => 'Russian'],
                ['code' => 'sk-sk', 'value' => 'Slovak'],
                ['code' => 'sl-si', 'value' => 'Slovenian'],
                ['code' => 'sr-rs', 'value' => 'Serbian'],
                ['code' => 'sv-se', 'value' => 'Swedish'],
                ['code' => 'tr-tr', 'value' => 'Turkish'],
                ['code' => 'zh-cn', 'value' => 'Chinese (Mandarin Simplified)'],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/languages')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowAllLanguageLevels()
    {
        $expectedArray = [
            'language_levels' => [
                ['name' => 'regular'],
                ['name' => 'premium'],
                ['name' => 'enterprise'],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/language_levels')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->levels());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Language';
    }
}
