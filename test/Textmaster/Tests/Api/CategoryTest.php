<?php

namespace Textmaster\Tests\Api;

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllCategories()
    {
        $expectedArray = array(
            'categories' => array(
                array('code' => 'C001', 'value' => 'Agriculture'),
                array('code' => 'C002', 'value' => 'Aerospace'),
                array('code' => 'C003', 'value' => 'Animals/Pets/Plants'),
                array('code' => 'C004', 'value' => 'Arts/Culture/Literature'),
                array('code' => 'C005', 'value' => 'Automotive/Transportation'),
                array('code' => 'C006', 'value' => 'Computers/Technology/Software'),
                array('code' => 'C007', 'value' => 'Telecom'),
                array('code' => 'C008', 'value' => 'Real Estate/Construction/Building'),
                array('code' => 'C009', 'value' => 'Consumer Goods'),
                array('code' => 'C010', 'value' => 'Education'),
                array('code' => 'C011', 'value' => 'Entertainment'),
                array('code' => 'C012', 'value' => 'Ecology/Environment'),
                array('code' => 'C013', 'value' => 'Health/Biotechnology/Pharma'),
                array('code' => 'C014', 'value' => 'Internet'),
                array('code' => 'C015', 'value' => 'Policy/Government/Public'),
                array('code' => 'C016', 'value' => 'Publishing/Media/Communication'),
                array('code' => 'C017', 'value' => 'Religion'),
                array('code' => 'C018', 'value' => 'Food/Beverages'),
                array('code' => 'C019', 'value' => 'Retail'),
                array('code' => 'C020', 'value' => 'Fashion/Luxury/Textiles'),
                array('code' => 'C021', 'value' => 'Travel/Tourism'),
                array('code' => 'C022', 'value' => 'Natural Resources/Energy'),
                array('code' => 'C023', 'value' => 'Banking/Financial Services/Insurance'),
                array('code' => 'C024', 'value' => 'Legal Affairs/Tax/Law'),
                array('code' => 'C025', 'value' => 'Raw Materials/Industrial Goods'),
                array('code' => 'C026', 'value' => 'Lifestyle/Leisure/Hobbies'),
                array('code' => 'C027', 'value' => 'Sports'),
                array('code' => 'C028', 'value' => 'Home/Family/Friends/Children'),
                array('code' => 'C029', 'value' => 'Economy/Financial Markets'),
                array('code' => 'C030', 'value' => 'Science'),
                array('code' => 'C031', 'value' => 'Human Resources/Employment'),
                array('code' => 'C032', 'value' => 'Adult (Pornography, Violence, etc.)'),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/categories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Category';
    }
}
