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

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllCategories()
    {
        $expectedArray = [
            'categories' => [
                ['code' => 'C001', 'value' => 'Agriculture'],
                ['code' => 'C002', 'value' => 'Aerospace'],
                ['code' => 'C003', 'value' => 'Animals/Pets/Plants'],
                ['code' => 'C004', 'value' => 'Arts/Culture/Literature'],
                ['code' => 'C005', 'value' => 'Automotive/Transportation'],
                ['code' => 'C006', 'value' => 'Computers/Technology/Software'],
                ['code' => 'C007', 'value' => 'Telecom'],
                ['code' => 'C008', 'value' => 'Real Estate/Construction/Building'],
                ['code' => 'C009', 'value' => 'Consumer Goods'],
                ['code' => 'C010', 'value' => 'Education'],
                ['code' => 'C011', 'value' => 'Entertainment'],
                ['code' => 'C012', 'value' => 'Ecology/Environment'],
                ['code' => 'C013', 'value' => 'Health/Biotechnology/Pharma'],
                ['code' => 'C014', 'value' => 'Internet'],
                ['code' => 'C015', 'value' => 'Policy/Government/Public'],
                ['code' => 'C016', 'value' => 'Publishing/Media/Communication'],
                ['code' => 'C017', 'value' => 'Religion'],
                ['code' => 'C018', 'value' => 'Food/Beverages'],
                ['code' => 'C019', 'value' => 'Retail'],
                ['code' => 'C020', 'value' => 'Fashion/Luxury/Textiles'],
                ['code' => 'C021', 'value' => 'Travel/Tourism'],
                ['code' => 'C022', 'value' => 'Natural Resources/Energy'],
                ['code' => 'C023', 'value' => 'Banking/Financial Services/Insurance'],
                ['code' => 'C024', 'value' => 'Legal Affairs/Tax/Law'],
                ['code' => 'C025', 'value' => 'Raw Materials/Industrial Goods'],
                ['code' => 'C026', 'value' => 'Lifestyle/Leisure/Hobbies'],
                ['code' => 'C027', 'value' => 'Sports'],
                ['code' => 'C028', 'value' => 'Home/Family/Friends/Children'],
                ['code' => 'C029', 'value' => 'Economy/Financial Markets'],
                ['code' => 'C030', 'value' => 'Science'],
                ['code' => 'C031', 'value' => 'Human Resources/Employment'],
                ['code' => 'C032', 'value' => 'Adult (Pornography, Violence, etc.)'],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/categories')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Category';
    }
}
