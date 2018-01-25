<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Translator;

use Textmaster\Exception\UnexpectedTypeException;
use Textmaster\Model\DocumentInterface;
use Textmaster\Translator\Adapter\AdapterInterface;
use Textmaster\Translator\Provider\MappingProviderInterface;
use Textmaster\Translator\Translator;

class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $adapterMock = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock];

        $subjectMock = $this->createMock(\stdClass::class);
        $documentMock = $this->createMock(DocumentInterface::class);

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn([]);

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $adapterMock->expects($this->once())
            ->method('push')
            ->willReturn($documentMock);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->push($subjectMock, $documentMock);
    }

    /**
     * @test
     */
    public function shouldCreateFromFactory()
    {
        $adapterMock = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $documentFactoryMock = $this->createMock('Textmaster\Translator\Factory\DocumentFactoryInterface');
        $adapters = [$adapterMock];

        $subjectMock = $this->createMock(\stdClass::class);
        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $documentFactoryMock->expects($this->once())
            ->method('createDocument')
            ->willReturn($documentMock);

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn([]);

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $adapterMock->expects($this->once())
            ->method('push')
            ->willReturn($documentMock);

        $translator = new Translator($adapters, $mappingProviderMock, $documentFactoryMock);
        $translator->push($subjectMock);
    }

    /**
     * @test
     */
    public function shouldComplete()
    {
        $adapterMock = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock];

        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $adapterMock->expects($this->once())
            ->method('complete')
            ->willReturn(true);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->complete($documentMock);
    }

    /**
     * @test
     */
    public function shouldCompleteWhenTwoAdapters()
    {
        $adapterMock1 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock1, $adapterMock2];

        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $adapterMock1->expects($this->once())
            ->method('complete')
            ->will($this->throwException(new UnexpectedTypeException('value', 'expectedType')));

        $adapterMock2->expects($this->once())
            ->method('complete')
            ->willReturn(true);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->complete($documentMock);
    }

    /**
     * @test
     */
    public function shouldGetSubjectFromDocument()
    {
        $adapterMock1 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock1, $adapterMock2];

        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');
        $subjectMock = $this->createMock(\stdClass::class);

        $adapterMock1->expects($this->once())
            ->method('getSubjectFromDocument')
            ->willReturn(null);

        $adapterMock2->expects($this->once())
            ->method('getSubjectFromDocument')
            ->willReturn($subjectMock);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->getSubjectFromDocument($documentMock);
    }

    /**
     * @test
     */
    public function shouldCompareNoDiff()
    {
        $adapterMock = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock];

        $expected = [
            'original' => ['property1' => 'Original content'],
            'translated' => ['property1' => 'Translated content'],
        ];
        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $adapterMock->expects($this->once())
            ->method('compare')
            ->willReturn($expected);

        $translator = new Translator($adapters, $mappingProviderMock);
        $comparison = $translator->compare($documentMock);

        $this->assertSame($expected, $comparison);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotCreate()
    {
        $adapterMock = $this->createMock(AdapterInterface::class);
        $mappingProviderMock = $this->createMock(MappingProviderInterface::class);
        $adapters = [$adapterMock];

        $subjectMock = $this->createMock(\stdClass::class);
        $documentMock = $this->createMock(DocumentInterface::class);

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn([]);

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(false);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->push($subjectMock, $documentMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotComplete()
    {
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [];

        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->complete($documentMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotCreateFromFactory()
    {
        $adapterMock = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock];

        $subjectMock = $this->createMock(\stdClass::class);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->push($subjectMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotGetSubjectFromDocument()
    {
        $adapterMock1 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->createMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->createMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = [$adapterMock1, $adapterMock2];

        $documentMock = $this->createMock('Textmaster\Model\DocumentInterface');

        $adapterMock1->expects($this->once())
            ->method('getSubjectFromDocument')
            ->willReturn(null);

        $adapterMock2->expects($this->once())
            ->method('getSubjectFromDocument')
            ->willReturn(null);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->getSubjectFromDocument($documentMock);
    }
}
