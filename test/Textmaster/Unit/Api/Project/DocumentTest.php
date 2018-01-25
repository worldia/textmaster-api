<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api\Project;

use Textmaster\Unit\Api\TestCase;

class DocumentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllDocuments()
    {
        $expectedArray = [
            'documents' => [
                [
                    'status' => 'waiting_assignment',
                    'skip_copyscape' => false,
                    'title' => 'document_6',
                    'instructions' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'word_count' => 200,
                    'word_count_rule' => 0,
                    'keywords_repeat_count' => 1,
                    'deliver_work_as_file' => false,
                    'custom_data' => [],
                    'plagiarism_analysis' => [],
                    'written_words' => 0,
                    'type' => 'standard',
                    'id' => '55b24260736f76641a000112',
                    'project_id' => '55b24260736f76641a0000e5',
                    'callback' => [],
                    'reference' => 'PR-2D3-54974-00000',
                    'ctype' => 'proofreading',
                    'keyword_list' => 'foo, bar, baz',
                    'satisfaction' => null,
                    'completion' => 0,
                    'can_post_message_to_author' => false,
                    'author_work' => [],
                    'author_id' => null,
                    'author_rating' => 1,
                    'original_content' => 'foo bar',
                    'created_at' => [
                        'day' => 24,
                        'month' => 7,
                        'year' => 2015,
                        'full' => '2015-07-24 13:49:20 UTC',
                    ],
                    'updated_at' => [
                        'day' => 24,
                        'month' => 7,
                        'year' => 2015,
                        'full' => '2015-07-24 13:49:20 UTC',
                    ],
                    'completed_at' => null,
                ],
            ],
            'total_pages' => 0,
            'count' => 1,
            'page' => 1,
            'per_page' => 20,
            'previous_page' => null,
            'next_page' => null,
        ];

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
        $expectedArray = [
            ['id' => 1, 'name' => 'Test document 1'],
            ['id' => 2, 'name' => 'Test document 2'],
        ];

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
        $expectedArray = ['id' => 1, 'name' => 'Test document 1'];

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
        $expectedArray = ['id' => 3, 'name' => 'Test document 3'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/documents')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->create([
            'name' => 'Test document 3',
            'project_id' => 1,
        ]));
    }

    /**
     * @test
     */
    public function shouldUpdateDocument()
    {
        $expectedArray = ['id' => 3, 'name' => 'Renamed test document 3'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/documents/3')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->update(3, [
            'name' => 'Test document 3',
            'project_id' => 1,
        ]));
    }

    /**
     * @test
     */
    public function shouldRemoveDocument()
    {
        $expectedArray = ['id' => 3, 'name' => 'Test document 3'];

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
        $expectedArray = ['id' => 3, 'name' => 'Test document 3'];

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
        $expectedArray = ['id' => 3, 'name' => 'Test document 3'];

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
        $expectedArray = ['id' => 3, 'name' => 'Test document 3'];

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
        $expectedArray = [
            ['id' => 3, 'name' => 'Test document 3'],
            ['id' => 4, 'name' => 'Test document 4'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchComplete([3, 4]));
    }

    /**
     * @test
     */
    public function shouldBatchCompleteDocumentsWithSatisfactionAndMessage()
    {
        $expectedArray = [
            ['id' => 3, 'name' => 'Test document 3'],
            ['id' => 4, 'name' => 'Test document 4'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents/complete')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchComplete([3, 4], 'positive', 'Good job!'));
    }

    /**
     * @test
     */
    public function shouldBatchCreateDocuments()
    {
        $expectedArray = [
            ['id' => 3, 'name' => 'Test document 3'],
            ['id' => 4, 'name' => 'Test document 4'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/batch/documents')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->batchCreate([
            ['name' => 'Test document 3'],
            ['name' => 'Test document 4'],
        ]));
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
        $httpClientMock = $this->createMock('Textmaster\HttpClient\HttpClientInterface');

        $client = new \Textmaster\Client($httpClientMock);

        return $this->createMockBuilder($this->getApiClass())
            ->setMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client, 1])
            ->createMock();
    }
}
