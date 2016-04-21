<?php

namespace Textmaster\Tests\Model;

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
        $showValues = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => '654321',
        );
        $updateValues = array(
            'id' => '123456',
            'title' => 'New Title',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );
        $projectValues = array(
            'id' => $projectId,
            'name' => 'Project 1',
            'status' => ProjectInterface::STATUS_IN_CREATION,
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
        );

        $clientMock = $this->getMock('Textmaster\Client', array('projects'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents', 'show'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('show', 'update'), array($clientMock, $projectId), '', false);

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

        $this->clientMock = $clientMock;
    }

    /**
     * @test
     */
    public function shouldCreateEmpty()
    {
        $title = 'Document 1';
        $originalContent = 'Text to translate.';
        $instructions = 'Translating instructions.';

        $document = new Document($this->clientMock);
        $document
            ->setTitle($title)
            ->setOriginalContent($originalContent)
            ->setInstructions($instructions)
        ;

        $this->assertNull($document->getId());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertEquals($title, $document->getTitle());
        $this->assertEquals($originalContent, $document->getOriginalContent());
        $this->assertEquals($instructions, $document->getInstructions());
    }

    /**
     * @test
     */
    public function shouldCreateFromValues()
    {
        $projectId = '654321';
        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $document = new Document($this->clientMock, $values);

        $this->assertEquals('123456', $document->getId());
        $this->assertEquals('Document 1', $document->getTitle());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertEquals('Text to translate.', $document->getOriginalContent());
        $this->assertEquals('Translating instructions.', $document->getInstructions());
    }

    /**
     * @test
     */
    public function shouldCreateToLoad()
    {
        $projectId = '654321';
        $valuesToCreate = array(
            'id' => '123456',
            'project_id' => $projectId,
        );

        $document = new Document($this->clientMock, $valuesToCreate);

        $this->assertEquals('123456', $document->getId());
        $this->assertEquals('Document 1', $document->getTitle());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertEquals('Text to translate.', $document->getOriginalContent());
        $this->assertEquals('Translating instructions.', $document->getInstructions());
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $projectId = '654321';
        $valuesToCreate = array(
            'id' => '123456',
            'project_id' => $projectId,
        );

        $document = new Document($this->clientMock, $valuesToCreate);
        $this->assertEquals('Document 1', $document->getTitle());

        $document->setTitle('New Title');
        $document->save();

        $this->assertEquals('New Title', $document->getTitle());
    }

    /**
     * @test
     */
    public function shouldGetProject()
    {
        $projectId = '654321';
        $valuesToCreate = array(
            'id' => '123456',
            'project_id' => $projectId,
        );

        $document = new Document($this->clientMock, $valuesToCreate);
        $project = $document->getProject();

        $this->assertEquals('Textmaster\Model\Project', get_class($project));
        $this->assertEquals($projectId, $project->getId());
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $projectId = '654321';
        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_PROGRESS,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $clientMock = $this->getMock('Textmaster\Client');

        $document = new Document($clientMock, $values);
        $document->setTitle('Change title on immutable');
    }
}
