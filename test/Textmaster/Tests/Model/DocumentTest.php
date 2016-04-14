<?php

namespace Textmaster\Tests\Model;

use Textmaster\Model\Document;
use Textmaster\Model\DocumentInterface;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateEmpty()
    {
        $title = 'Document 1';
        $originalContent = 'Text to translate.';
        $instructions = 'Translating instructions.';

        $clientMock = $this->getMock('Textmaster\Client');

        $document = new Document($clientMock);
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

        $clientMock = $this->getMock('Textmaster\Client');

        $document = new Document($clientMock, $values);

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

        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('projects'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('show'), array($clientMock, $projectId), '', false);

        $clientMock->method('projects')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $documentApiMock->method('show')
            ->willReturn($values);

        $document = new Document($clientMock, $valuesToCreate);

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
        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $updateValues = array(
            'id' => '123456',
            'title' => 'New Title',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('projects'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('update'), array($clientMock, $projectId), '', false);

        $clientMock->method('projects')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $documentApiMock->method('update')
            ->willReturn($updateValues);

        $document = new Document($clientMock, $values);
        $this->assertEquals('Document 1', $document->getTitle());

        $document->setTitle('New Title');
        $document->save();

        $this->assertEquals('New Title', $document->getTitle());
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
