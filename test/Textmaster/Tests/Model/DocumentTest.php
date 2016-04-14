<?php

namespace Textmaster\Tests\Model;

use Textmaster\Model\Document;
use Textmaster\Model\DocumentInterface;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $projectId = '654321';

        $toCreateValues = array(
            'project_id' => $projectId,
        );

        $createdValues = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'instructions' => 'Translating instructions.',
            'project_id' => $projectId,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('create'), array($clientMock, $projectId), '', false);

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $documentApiMock->method('create')
            ->willReturn($createdValues);

        $document = new Document($clientMock, $toCreateValues);

        $this->assertNull($document->getId());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());

        $document->save();

        $this->assertEquals('123456', $document->getId());
        $this->assertEquals('Document 1', $document->getTitle());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertEquals('Text to translate.', $document->getOriginalContent());
        $this->assertEquals('Translating instructions.', $document->getInstructions());
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

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array(), array($clientMock, $projectId), '', false);

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

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

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('update'), array($clientMock, $projectId), '', false);

        $clientMock->method('api')
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
     */
    public function shouldGetProject()
    {
        $projectId = '654321';
        $documentValues = array(
            'id' => '123456',
            'project_id' => $projectId,
        );

        $projectValues = array(
            'id' => '654321',
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents', 'show'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('show'), array($clientMock, $projectId), '', false);

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $projectApiMock->method('show')
            ->willReturn($projectValues);

        $document = new Document($clientMock, $documentValues);
        $project = $document->getProject();

        $this->assertTrue(in_array('Textmaster\Model\ProjectInterface', class_implements($project)));
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

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array(), array($clientMock, $projectId), '', false);

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $document = new Document($clientMock, $values);

        $document->setTitle('New name');
    }
}
