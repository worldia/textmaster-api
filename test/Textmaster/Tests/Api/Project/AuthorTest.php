<?php

namespace Textmaster\Tests\Api\Project;

use Textmaster\Tests\Api\TestCase;

class AuthorTest extends TestCase
{
    protected $authorResult = array(
        'my_authors' => array(
            array(
                'description' => 'description',
                'tags' => array(),
                'status' => 'my_textmaster',
                'id' => '53d7bf8053ecaaf8aa0005ba',
                'author_id' => '53d7bf7f53ecaaf8aa00056f',
                'author_ref' => 'A-7B6F-FM',
                'latest_activity' => '2014-07-29 18:35:52 +0300',
                'created_at' => array('day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:32 +0300'),
                'updated_at' => array('day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:32 +0300'),
            ),
             array(
                'description' => 'description',
                'tags' => array(),
                'status' => 'uncategorized',
                'id' => '53d7bf8053ecaaf8aa0005bb',
                'author_id' => '53d7bf7f53ecaaf8aa00057f',
                'author_ref' => 'A-7B7F-FM',
                'latest_activity' => '2014-07-29 18:35:52 +0300',
                'created_at' => array('day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:32 +0300'),
                'updated_at' => array('day' => 29, 'month' => 7, 'year' => 2014, 'full' => '2014-07-29 18:36:32 +0300'),
            ),
        ),
        'total_pages' => 0,
        'count' => 2,
        'page' => 1,
        'per_page' => 20,
        'previous_page' => null,
        'next_page' => null,
    );

    /**
     * @test
     */
    public function shouldShowAllAuthors()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertEquals($this->authorResult, $api->all(1));
    }

    /**
     * @test
     */
    public function shouldShowAllAuthorsByStatus()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/my_authors')
            ->will($this->returnValue($this->authorResult));

        $this->assertEquals($this->authorResult, $api->all(1, 'blacklisted'));
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Project\Author';
    }
}
