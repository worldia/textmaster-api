<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Model;

use Textmaster\Model\Document;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    protected $clientMock;

    public function setUp()
    {
        parent::setUp();

        $projectId = '654321';
        $showValues = [
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => '654321',
        ];
        $updateValues = [
            'id' => '123456',
            'title' => 'New Title',
            'status' => DocumentInterface::STATUS_IN_REVIEW,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        ];
        $completeValues = [
            'id' => '123456',
            'title' => 'New Title',
            'status' => DocumentInterface::STATUS_COMPLETED,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        ];
        $projectValues = [
            'id' => $projectId,
            'name' => 'Project 1',
            'status' => ProjectInterface::STATUS_IN_CREATION,
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => ['language_level' => 'premium'],
        ];

        $clientMock = $this->getMockBuilder('Textmaster\Client')->setMethods(['projects'])->disableOriginalConstructor()->getMock();
        $projectApiMock = $this->getMock('Textmaster\Api\Project', ['documents', 'show'], [$clientMock]);
        $documentApiMock = $this->getMock('Textmaster\Api\Document', ['show', 'update', 'complete', 'supportMessages'], [$clientMock, $projectId], '', false);
        $supportMessageApiMock = $this->getMock('Textmaster\Api\Project\Document\SupportMessage', ['create'], [$clientMock], '', false);

        $clientMock->method('projects')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $projectApiMock->method('show')
            ->willReturn($projectValues);

        $documentApiMock->method('show')
            ->willReturn($showValues);

        $documentApiMock->method('update')
            ->willReturn($updateValues);

        $documentApiMock->method('complete')
            ->willReturn($completeValues);

        $documentApiMock->method('supportMessages')
            ->willReturn($supportMessageApiMock);

        $supportMessageApiMock->method('create')
            ->willReturn(null);

        $this->clientMock = $clientMock;
    }

    /**
     * @test
     */
    public function shouldCreateEmpty()
    {
        $title = 'Document 1';
        $originalContent = ['key' => ['original_phrase' => 'Text to translate.']];
        $instructions = 'Translating instructions.';
        $customData = ['Custom data can be any type'];

        $document = new Document($this->clientMock);
        $document
            ->setTitle($title)
            ->setOriginalContent($originalContent)
            ->setInstructions($instructions)
            ->setCustomData($customData)
        ;

        $this->assertNull($document->getId());
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertSame($title, $document->getTitle());
        $this->assertSame($originalContent, $document->getOriginalContent());
        $this->assertSame($instructions, $document->getInstructions());
        $this->assertSame($customData, $document->getCustomData());
        $this->assertSame(DocumentInterface::TYPE_KEY_VALUE, $document->getType());
    }

    /**
     * @test
     */
    public function shouldCreateFromValues()
    {
        $projectId = '654321';
        $values = [
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
            'created_at' => [
                'day' => 9,
                'month' => 6,
                'year' => 2016,
                'full' => '2016-06-09 10:37:40 UTC',
            ],
            'updated_at' => [
                'day' => 10,
                'month' => 6,
                'year' => 2016,
                'full' => '2016-06-10 15:37:40 UTC',
            ],
        ];

        $document = new Document($this->clientMock, $values);

        $this->assertSame('123456', $document->getId());
        $this->assertSame('Document 1', $document->getTitle());
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertSame('Text to translate.', $document->getOriginalContent());
        $this->assertSame('Translating instructions.', $document->getInstructions());

        $expectedDate = new \DateTime('2016-06-09 10:37:40 UTC');
        $this->assertSame($expectedDate, $document->getCreatedAt());
        $this->assertSame('20160609 10:37:40', $document->getCreatedAt()->format('Ymd H:i:s'));

        $expectedDate = new \DateTime('2016-06-10 15:37:40 UTC');
        $this->assertSame($expectedDate, $document->getUpdatedAt());
        $this->assertSame('20160610 15:37:40', $document->getUpdatedAt()->format('Ymd H:i:s'));
    }

    /**
     * @test
     */
    public function shouldGetTranslatedContentForStandard()
    {
        $projectId = '654321';
        $values = [
            'id' => '123456',
            'title' => 'Document 1',
            'type' => DocumentInterface::TYPE_STANDARD,
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
            'author_work' => ['free_text' => 'Translated text.'],
        ];

        $document = new Document($this->clientMock, $values);

        $this->assertSame('123456', $document->getId());
        $this->assertSame('Document 1', $document->getTitle());
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertSame('Text to translate.', $document->getOriginalContent());
        $this->assertSame('Translating instructions.', $document->getInstructions());
        $this->assertSame('Translated text.', $document->getTranslatedContent());
    }

    /**
     * @test
     */
    public function shouldGetTranslatedContentForKeyValue()
    {
        $projectId = '654321';
        $values = [
            'id' => '123456',
            'title' => 'Document 1',
            'type' => DocumentInterface::TYPE_KEY_VALUE,
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => [
                'key1' => ['original_phrase' => 'Text to translate.', 'completed_phrase' => 'Translated text.'],
                'key2' => ['original_phrase' => 'Text to translate.', 'completed_phrase' => 'Translated text.'],
            ],
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
            'author_work' => [
                'key1' => 'Translated text.',
                'key2' => 'Translated text.',
            ],
        ];

        $document = new Document($this->clientMock, $values);

        $this->assertSame('123456', $document->getId());
        $this->assertSame('Document 1', $document->getTitle());
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertSame($values['original_content'], $document->getOriginalContent());
        $this->assertSame('Translating instructions.', $document->getInstructions());
        $this->assertSame($values['author_work'], $document->getTranslatedContent());
    }

    /**
     * @test
     */
    public function shouldCreateToLoad()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);

        $this->assertSame('123456', $document->getId());
        $this->assertSame('Document 1', $document->getTitle());
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertSame('Text to translate.', $document->getOriginalContent());
        $this->assertSame('Translating instructions.', $document->getInstructions());
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $this->assertSame('Document 1', $document->getTitle());

        $document->setTitle('New Title');
        $document->save();

        $this->assertSame('New Title', $document->getTitle());
    }

    /**
     * @test
     */
    public function shouldGetProject()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $project = $document->getProject();

        $this->assertSame('Textmaster\Model\Project', get_class($project));
        $this->assertSame($projectId, $project->getId());
    }

    /**
     * @test
     */
    public function shouldSetArrayOriginalContent()
    {
        $originalContent = [
            'translation1' => ['original_phrase' => 'Text to translate.'],
            'translation2' => ['original_phrase' => 'An other text to translate.'],
        ];

        $document = new Document($this->clientMock);
        $document->setOriginalContent($originalContent);

        $this->assertSame($originalContent, $document->getOriginalContent());
    }

    /**
     * @test
     */
    public function shouldCountWords()
    {
        $originalContent = [
            'translation1' => ['original_phrase' => 'Text 1 to translate.'],
            'translation2' => ['original_phrase' => 'An other text to translate.'],
        ];

        $document = new Document($this->clientMock);
        $document->setOriginalContent($originalContent);

        $this->assertSame(9, $document->getWordCount());

        $document->setOriginalContent('A single phrase to translate.');

        $this->assertSame(5, $document->getWordCount());
    }

    /**
     * @test
     */
    public function shouldSetCallback()
    {
        $callback = [
            DocumentInterface::STATUS_CANCELED => ['url' => 'http://my.host/canceled_callback'],
            DocumentInterface::STATUS_IN_REVIEW => ['url' => 'http://my.host/in_review_callback'],
        ];

        $document = new Document($this->clientMock);
        $document->setCallback($callback);

        $this->assertSame($callback, $document->getCallback());
    }

    /**
     * @test
     */
    public function shouldComplete()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $document->save();
        $document->complete(DocumentInterface::SATISFACTION_POSITIVE, 'Good job!');

        $this->assertSame(DocumentInterface::STATUS_COMPLETED, $document->getStatus());
    }

    /**
     * @test
     */
    public function shouldReject()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $document->save();
        $document->reject('Bad job!');

        $this->assertSame('123456', $document->getId());
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotSetBadArrayOriginalContent()
    {
        $originalContent = [
            'translation1' => ['original_phrase' => 'Text to translate.'],
            'translation2' => ['bad_key' => 'An other text to translate.'],
        ];

        $document = new Document($this->clientMock);
        $document->setOriginalContent($originalContent);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $document->save();
        $document->setTitle('Change title on immutable');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotSetWrongCallback()
    {
        $callback = [
            'NOT_A_DOCUMENT_STATUS' => ['url' => 'http://my.host/bad_callback'],
        ];

        $document = new Document($this->clientMock);
        $document->setCallback($callback);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotCompleteWithWrongSatisfaction()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $document->save();
        $document->complete('Wrong satisfaction value');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\BadMethodCallException
     */
    public function shouldNotCompleteNotInReview()
    {
        $projectId = '654321';
        $valuesToCreate = [
            'id' => '123456',
            'project_id' => $projectId,
        ];

        $document = new Document($this->clientMock, $valuesToCreate);
        $document->complete();
    }
}
