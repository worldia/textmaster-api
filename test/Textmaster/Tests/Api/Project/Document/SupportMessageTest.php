<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Tests\Api\Project\Document;

use Textmaster\Tests\Api\TestCase;

class SupportMessageTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllSupportMessages()
    {
        $expectedArray = array(
            'support_messages' => array(
                array(
                    'content' => 'Hey, we need a small fix there',
                    'message' => 'Hey, we need a small fix there',
                    'author_id' => '53d7bfa253ecaaf8aa000d3d',
                    'written_by_you' => true,
                    'written_by_author' => false,
                    'author_ref' => 'C-7B3D-FM',
                    'created_at' => array(
                        'day' => 29,
                        'month' => 7,
                        'year' => 2014,
                        'full' => '2014-07-29 18:37:09 +0300',
                    ),
                ),
                array(
                    'content' => 'done',
                    'message' => 'done',
                    'author_id' => '53d7bfa253ecaaf8aa000d31',
                    'written_by_you' => false,
                    'written_by_author' => true,
                    'author_ref' => 'A-7B31-FM',
                    'created_at' => array(
                        'day' => 29,
                        'month' => 7,
                        'year' => 2014,
                        'full' => '2014-07-29 18:37:09 +0300',
                    ),
                ),
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/documents/1/support_messages')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all(1, 1));
    }

    /**
     * @test
     */
    public function shouldCreateSupportMessage()
    {
        $expectedArray = array(
            'content' => 'Hey, we need a small fix there',
            'message' => 'Hey, we need a small fix there',
            'author_id' => '53d7bfa253ecaaf8aa000d3d',
            'written_by_you' => true,
            'written_by_author' => false,
            'author_ref' => 'C-7B3D-FM',
            'created_at' => array(
                'day' => 29,
                'month' => 7,
                'year' => 2014,
                'full' => '2014-07-29 18:37:09 +0300',
            ),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/documents/1/support_messages')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->create(1, 1, 'Hey, we need a small fix there'));
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Project\Document\SupportMessage';
    }
}
