<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
        $subjectMock = $this->createMock(\stdClass::class);
        $clientMock = $this->getMockBuilder('Textmaster\Client')->disableOriginalConstructor()->getMock();

        $project = new Project($clientMock, ['id' => '123456', 'name' => 'Project-1']);
        $params = [
            'project' => $project,
            'document' => [
                'title' => 'Super title',
            ],
        ];

        $factory = new DefaultDocumentFactory();
        $document = $factory->createDocument($subjectMock, $params);

        $this->assertTrue(in_array('Textmaster\Model\DocumentInterface', class_implements($document), true));
        $this->assertSame('Super title', $document->getTitle());
    }
}
