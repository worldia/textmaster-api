<?php

namespace Textmaster\Unit\Translator\Factory;

use Textmaster\Model\Project;
use Textmaster\Translator\Factory\DefaultDocumentFactory;

class DefaultDocumentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateDocument()
    {
        $subjectMock = $this->getMock('SubjectInterface');
        $clientMock = $this->getMock('Textmaster\Client');

        $project = new Project($clientMock, array('id' => '123456', 'name' => 'Project-1'));
        $params = array(
            'project' => $project,
            'document' => array(
                'title' => 'Super title',
            ),
        );

        $factory = new DefaultDocumentFactory();
        $document = $factory->createDocument($subjectMock, $params);

        $this->assertTrue(in_array('Textmaster\Model\DocumentInterface', class_implements($document)));
        $this->assertSame('Super title', $document->getTitle());
    }
}
