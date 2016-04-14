<?php

namespace Textmaster\Tests\Model;

use Textmaster\Model\Document;
use Textmaster\Model\DocumentInterface;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSerialize()
    {
        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'original_content' => 'Text to translate.',
            'translated_content' => 'Texte à traduire.',
            'project_id' => '123456',
        );

        $document = new Document();
        $document->fromArray($values);

        $this->assertEquals('123456', $document->getId());
        $this->assertEquals('Document 1', $document->getTitle());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
        $this->assertEquals('Text to translate.', $document->getOriginalContent());
        $this->assertEquals('Texte à traduire.', $document->getTranslatedContent());
        $this->assertEquals('123456', $document->getProjectId());

        $result = $document->toArray();

        $this->assertEquals($result, $values);
    }

    /**
     * @test
     */
    public function shouldUseSetters()
    {
        $document = new Document();

        $title = 'Document 1';
        $description = 'Description';
        $instructions = 'Instructions';
        $originalContent = 'Original content';

        $document
            ->setTitle($title)
            ->setDescription($description)
            ->setInstructions($instructions)
            ->setOriginalContent($originalContent)
        ;

        $this->assertEquals($title, $document->getTitle());
        $this->assertEquals($description, $document->getDescription());
        $this->assertEquals($instructions, $document->getInstructions());
        $this->assertEquals($originalContent, $document->getOriginalContent());
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $values = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_PROGRESS,
            'original_content' => 'Text to translate.',
            'translated_content' => 'Texte à traduire.',
            'project_id' => '123456',
        );

        $document = new Document();
        $document->fromArray($values);

        $document->setTitle('New title');
    }
}
