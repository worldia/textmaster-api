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

class LocaleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllLocales()
    {
        $expectedArray = array(
            'locales' => array(
                array('code' => 'en-US', 'name' => 'United States (EN & USD)'),
                array('code' => 'fr-FR', 'name' => 'France (FR & EUR)'),
                array('code' => 'es-ES', 'name' => 'España (ES & EUR)'),
                array('code' => 'pt-PT', 'name' => 'Portugal (PT & EUR)'),
                array('code' => 'it-IT', 'name' => 'Italia (IT & EUR)'),
                array('code' => 'en-GB', 'name' => 'United Kingdom (EN & GBP)'),
                array('code' => 'de-DE', 'name' => 'Deutschland (DE & EUR)'),
                array('code' => 'pt-BR', 'name' => 'Brasil (PT & BRL)'),
                array('code' => 'en-EU', 'name' => 'Europe (EN & EUR)'),
                array('code' => 'xx-XX', 'name' => 'DevMode (EUR)'),
            ),
        );

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
        $expectedArray = array(
            'word_count' => 1,
            'translation' => array(
                array('name' => 'regular', 'value' => 0.039),
                array('name' => 'premium', 'value' => 0.078),
                array('name' => 'quality', 'value' => 0.052000000000000005),
                array('name' => 'expertise', 'value' => 0.13),
                array('name' => 'specific_attachment', 'value' => 0.078),
                array('name' => 'author_location', 'value' => 0.026000000000000002),
                array('name' => 'priority', 'value' => 0.052000000000000005),
            ),
            'proofreading' => array(
                array('name' => 'regular', 'value' => 0.0195),
                array('name' => 'premium', 'value' => 0.039),
                array('name' => 'quality', 'value' => 0.026000000000000002),
                array('name' => 'expertise', 'value' => 0.065000000000000002),
                array('name' => 'specific_attachment', 'value' => 0.039),
                array('name' => 'author_location', 'value' => 0.026000000000000002),
                array('name' => 'priority', 'value' => 0.026000000000000002),
            ),
            'copywriting' => array(
                array('name' => 'regular', 'value' => 0.026000000000000002),
                array('name' => 'premium', 'value' => 0.065000000000000002),
                array('name' => 'quality', 'value' => 0.026000000000000002),
                array('name' => 'expertise', 'value' => 0.13),
                array('name' => 'specific_attachment', 'value' => 0.078),
                array('name' => 'author_location', 'value' => 0.026000000000000002),
                array('name' => 'priority', 'value' => 0.052000000000000005),
            ),
        );

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
        $expectedArray = array(
            array('id' => 'AD', 'name' => 'Andorra'),
            array('id' => 'AE', 'name' => 'United Arab Emirates'),
            array('id' => 'AF', 'name' => 'Afghanistan'),
            array('id' => 'AG', 'name' => 'Antigua And Barbuda'),
            array('id' => 'AI', 'name' => 'Anguilla'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/countries/fr_FR')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->countries('fr_FR'));
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Locale';
    }
}
