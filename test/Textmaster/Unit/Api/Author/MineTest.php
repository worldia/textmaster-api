<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api\Author;

use Textmaster\Unit\Api\TestCase;

class MineTest extends TestCase
{
    protected $authorResult = [
        'my_authors' => [
            [
                'description' => 'description',
                'tags' => [],
                'status' => 'my_textmaster',
                'id' => '53d7bf7c53ecaaf8aa000520',
                'author_id' => '53d7bf7c53ecaaf8aa000514',
                'author_ref' => 'A-7B14-FM',
                'latest_activity' => '2014-07-29 18:35:52 +0300',
                'created_at' => ['day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:28 +0300'],
                'updated_at' => ['day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:28 +0300'],
            ],
        ],
        'total_pages' => 0,
        'count' => 1,
        'page' => 1,
        'per_page' => 20,
        'previous_page' => null,
        'next_page' => null,
    ];

    /**
     * @test
     */
    public function shouldShowAllMyAuthors()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertSame($this->authorResult, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowAllMyAuthorsFilteredByStatus()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertSame($this->authorResult, $api->all('my_textmaster'));
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenFilteringMyAuthorsByInvalidStatus()
    {
        $this->getApiMock()->all('invalid_status');
    }

    /**
     * @test
     */
    public function shouldAddAnAuthorToMyAuthors()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertSame($this->authorResult, $api->add('53d7bf7d53ecaaf8aa00052e', 'my_textmaster'));
    }

    /**
     * @test
     */
    public function shouldAddAnAuthorToMyAuthorsWithDescription()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertSame($this->authorResult, $api->add('53d7bf7d53ecaaf8aa00052e', 'my_textmaster', 'Nice author'));
    }

    /**
     * @test
     */
    public function shouldUpdateAnAuthor()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/my_authors/53d7bf7d53ecaaf8aa00052e')
            ->will($this->returnValue($this->authorResult));

        $this->assertSame($this->authorResult, $api->update('53d7bf7d53ecaaf8aa00052e', 'my_textmaster', 'Nice author'));
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenUpdatingAnAuthorWithInvalidStatus()
    {
        $this->getApiMock()->update('53d7bf7d53ecaaf8aa00052e', 'invalid_status', 'Nice author');
    }

    /**
     * @test
     */
    public function shouldShowAuthorInfo()
    {
        $expectedArray = ['name' => 'Test author'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/my_authors/53d7bf7d53ecaaf8aa00052e')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->info('53d7bf7d53ecaaf8aa00052e'));
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenAddingAnAuthorToMyAuthorsWithInvalidStatus()
    {
        $this->getApiMock()->add('53d7bf7d53ecaaf8aa00052e', 'invalid_status', 'Nice author');
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Author\Mine';
    }
}
