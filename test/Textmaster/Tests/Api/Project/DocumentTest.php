<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Tests\Api\Project;

use Textmaster\Tests\Api\TestCase;

class DocumentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllDocuments()
    {
        $expectedArray = array(
            'documents' => array(
                array(
                    'status' => 'waiting_assignment',
                    'skip_copyscape' => false,
                    'title' => 'document_6',
                    'instructions' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'word_count' => 200,
                    'word_count_rule' => 0,
                    'keywords_repeat_count' => 1,
                    'deliver_work_as_file' => false,
                    'custom_data' => array(),
                    'plagiarism_analysis' => array(),
                    'written_words' => 0,
                    'type' => 'standard',
                    'id' => '55b24260736f76641a000112',
                    'project_id' => '55b24260736f76641a0000e5',
                    'callback' => array(),
                    'reference' => 'PR-2D3-54974-00000',
                    'ctype' => 'proofreading',
                    'keyword_list' => 'foo, bar, baz',
                    'satisfaction' => null,
                    'completion' => 0,
                    'can_post_message_to_author' => false,
                    'author_work' => array(),
                    'author_id' => null,
                    'author_rating' => 1,
                    'original_content' => 'foo bar',
                    'created_at' => array(
                        'day' => 24,
                        'month' => 7,
                        'year' => 2015,
                        'full' => '2015-07-24 13:49:20 UTC',
                    ),
                    'updated_at' => array(
                        'day' => 24,
                        'month' => 7,
                        'year' => 2015,
                        'full' => '2015-07-24 13:49:20 UTC',
                    ),
                    'completed_at' => null,
                ),
            ),
            'total_pages' => 0,
            'count' => 1,
            'page' => 1,
            'per_page' => 20,
            'previous_page' => null,
            'next_page' => null,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/documents')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all(1));
    }

    /**
     * @test
     */
    public function shouldFilterDocuments()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'Test document 1'),
            array('id' => 2, 'name' => 'Test document 2'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/documents/filter')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->filter());
    }

    /**
     * @test
     */
    public function shouldShowDocument()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test document 1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1/documents/1')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->show(1));
    }

    /**
     * @test
     */
    public function shouldCreateDocument()
    {
        $expectedArray = array('id' => 3, 'name' => 'Test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/documents')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->create(array(
            'name' => 'Test document 3',
            'project_id' => 1,
        )));
    }

    /**
     * @test
     */
    public function shouldUpdateDocument()
    {
        $expectedArray = array('id' => 3, 'name' => 'Renamed test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/documents/3')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->update(3, array(
            'name' => 'Test document 3',
            'project_id' => 1,
        )));
    }

    /**
     * @test
     */
    public function shouldRemoveDocument()
    {
        $expectedArray = array('id' => 3, 'name' => 'Test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('clients/projects/1/documents/3')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->remove(3));
    }

    /**
     * @test
     */
    public function shouldCompleteDocument()
    {
        $expectedArray = array('id' => 3, 'name' => 'Test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/documents/3/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->complete(3));
    }

    /**
     * @test
     */
    public function shouldCompleteDocumentWithSatisfaction()
    {
        $expectedArray = array('id' => 3, 'name' => 'Test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/documents/3/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->complete(3, 'positive'));
    }

    /**
     * @test
     */
    public function shouldCompleteDocumentWithMessage()
    {
        $expectedArray = array('id' => 3, 'name' => 'Test document 3');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/documents/3/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->complete(3, null, 'Good job'));
    }

    /**
     * @test
     */
    public function shouldBatchCompleteDocuments()
    {
        $expectedArray = array(
            array('id' => 3, 'name' => 'Test document 3'),
            array('id' => 4, 'name' => 'Test document 4'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchComplete(array(3, 4)));
    }

    /**
     * @test
     */
    public function shouldBatchCompleteDocumentsWithSatisfactionAndMessage()
    {
        $expectedArray = array(
            array('id' => 3, 'name' => 'Test document 3'),
            array('id' => 4, 'name' => 'Test document 4'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchComplete(array(3, 4), 'positive', 'Good job!'));
    }

    /**
     * @test
     */
    public function shouldBatchCreateDocuments()
    {
        $expectedArray = array(
            array('id' => 3, 'name' => 'Test document 3'),
            array('id' => 4, 'name' => 'Test document 4'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchCreate(array(
            array('name' => 'Test document 3'),
            array('name' => 'Test document 4'),
        )));
    }

    /**
     * @test
     */
    public function shouldGetSupportMessagesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\Project\Document\SupportMessage', $api->supportMessages());
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiClass()
    {
        return 'Textmaster\Api\Project\Document';
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiMock()
    {
        $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $httpClient
            ->expects($this->any())
            ->method('send');

        $mock = $this->getMock('Textmaster\HttpClient\HttpClient', array(), array(array(), $httpClient));

        $client = new \Textmaster\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'))
            ->setConstructorArgs(array($client, 1))
            ->getMock();
    }
}
