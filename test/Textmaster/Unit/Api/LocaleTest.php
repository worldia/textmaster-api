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

use Textmaster\Exception\InvalidArgumentException;

class LocaleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllLocales()
    {
        $expectedArray = [
            'locales' => [
                ['code' => 'en-US', 'name' => 'United States (EN & USD)'],
                ['code' => 'fr-FR', 'name' => 'France (FR & EUR)'],
                ['code' => 'es-ES', 'name' => 'España (ES & EUR)'],
                ['code' => 'pt-PT', 'name' => 'Portugal (PT & EUR)'],
                ['code' => 'it-IT', 'name' => 'Italia (IT & EUR)'],
                ['code' => 'en-GB', 'name' => 'United Kingdom (EN & GBP)'],
                ['code' => 'de-DE', 'name' => 'Deutschland (DE & EUR)'],
                ['code' => 'pt-BR', 'name' => 'Brasil (PT & BRL)'],
                ['code' => 'en-EU', 'name' => 'Europe (EN & EUR)'],
                ['code' => 'xx-XX', 'name' => 'DevMode (EUR)'],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/locales')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowReferencePricings()
    {
        $expectedArray = [
            'word_count' => 1,
            'translation' => [
                ['name' => 'regular', 'value' => 0.039],
                ['name' => 'premium', 'value' => 0.078],
                ['name' => 'quality', 'value' => 0.052000000000000005],
                ['name' => 'expertise', 'value' => 0.13],
                ['name' => 'specific_attachment', 'value' => 0.078],
                ['name' => 'author_location', 'value' => 0.026000000000000002],
                ['name' => 'priority', 'value' => 0.052000000000000005],
            ],
            'proofreading' => [
                ['name' => 'regular', 'value' => 0.0195],
                ['name' => 'premium', 'value' => 0.039],
                ['name' => 'quality', 'value' => 0.026000000000000002],
                ['name' => 'expertise', 'value' => 0.065000000000000002],
                ['name' => 'specific_attachment', 'value' => 0.039],
                ['name' => 'author_location', 'value' => 0.026000000000000002],
                ['name' => 'priority', 'value' => 0.026000000000000002],
            ],
            'copywriting' => [
                ['name' => 'regular', 'value' => 0.026000000000000002],
                ['name' => 'premium', 'value' => 0.065000000000000002],
                ['name' => 'quality', 'value' => 0.026000000000000002],
                ['name' => 'expertise', 'value' => 0.13],
                ['name' => 'specific_attachment', 'value' => 0.078],
                ['name' => 'author_location', 'value' => 0.026000000000000002],
                ['name' => 'priority', 'value' => 0.052000000000000005],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/reference_pricings/en-US')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->referencePricings('en-US'));
    }

    /**
     * @test
     */
    public function shouldShowAllCountries()
    {
        $expectedArray = [
            ['id' => 'AD', 'name' => 'Andorra'],
            ['id' => 'AE', 'name' => 'United Arab Emirates'],
            ['id' => 'AF', 'name' => 'Afghanistan'],
            ['id' => 'AG', 'name' => 'Antigua And Barbuda'],
            ['id' => 'AI', 'name' => 'Anguilla'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/countries/fr_FR')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->countries('fr_FR'));
    }

    /**
     * @test
     */
    public function shouldShowAbilities()
    {
        $api = $this->getApiMock();

        $this->setExpectedException('InvalidArgumentException', 'Invalid ability');
        $api->abilities('invalid', 1);
        $this->setExpectedException('InvalidArgumentException', 'Invalid page number');
        $api->abilities('translation', 'foo');
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Locale';
    }
}
