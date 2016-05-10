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

class BundleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllBundles()
    {
        $expectedArray = array(
            array(
                'name' => 'Starter',
                'id' => '51a54c9f4403ba63b7000005',
                'created_at' => array('day' => 29, 'month' => 5, 'year' => 2013, 'full' => '2013-05-29 03:32:31 +0300'),
                'updated_at' => array('day' => 20, 'month' => 4, 'year' => 2014, 'full' => '2014-04-20 16:13:34 +0300'),
            ),
            array(
                'name' => 'Small',
                'id' => '51a54ca04403ba63b7000009',
                'created_at' => array('day' => 29, 'month' => 5, 'year' => 2013, 'full' => '2013-05-29 03:32:32 +0300'),
                'updated_at' => array('day' => 22, 'month' => 4, 'year' => 2014, 'full' => '2014-04-22 17:44:17 +0300'),
            ),
            array(
                'name' => 'Medium',
                'id' => '51a54ca04403ba63b700000d',
                'created_at' => array('day' => 29, 'month' => 5, 'year' => 2013, 'full' => '2013-05-29 03:32:32 +0300'),
                'updated_at' => array('day' => 12, 'month' => 6, 'year' => 2014, 'full' => '2014-06-12 16:35:33 +0300'),
            ),
            array(
                'name' => 'Large',
                'id' => '51a54ca04403ba63b7000011',
                'created_at' => array('day' => 29, 'month' => 5, 'year' => 2013, 'full' => '2013-05-29 03:32:32 +0300'),
                'updated_at' => array('day' => 22, 'month' => 4, 'year' => 2014, 'full' => '2014-04-22 14:56:47 +0300'),
            ),
            array(
                'name' => 'X Large',
                'id' => '51a54ca04403ba63b7000015',
                'created_at' => array('day' => 29, 'month' => 5, 'year' => 2013, 'full' => '2013-05-29 03:32:32 +0300'),
                'updated_at' => array('day' => 8, 'month' => 4, 'year' => 2014, 'full' => '2014-04-08 17:01:11 +0300'),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('public/bundles')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Bundle';
    }
}
