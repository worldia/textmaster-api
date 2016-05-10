<?php

namespace Textmaster\Unit\Translator;

use Textmaster\Exception\UnexpectedTypeException;
use Textmaster\Translator\Translator;

class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $adapterMock = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock);

        $subjectMock = $this->getMock('Subject');
        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn(array());

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->create($subjectMock, $documentMock);
    }

    /**
     * @test
     */
    public function shouldCreateFromFactory()
    {
        $adapterMock = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $documentFactoryMock = $this->getMock('Textmaster\Translator\Factory\DocumentFactoryInterface');
        $adapters = array($adapterMock);

        $subjectMock = $this->getMock('Subject');
        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

        $documentFactoryMock->expects($this->once())
            ->method('createDocument')
            ->willReturn($documentMock);

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn(array());

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $translator = new Translator($adapters, $mappingProviderMock, $documentFactoryMock);
        $translator->create($subjectMock);
    }

    /**
     * @test
     */
    public function shouldComplete()
    {
        $adapterMock = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock);

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

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
        $adapterMock1 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock1, $adapterMock2);

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

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
        $adapterMock1 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock1, $adapterMock2);

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');
        $subjectMock = $this->getMock('Subject');

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
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotCreate()
    {
        $adapterMock = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock);

        $subjectMock = $this->getMock('Subject');
        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

        $mappingProviderMock->expects($this->once())
            ->method('getProperties')
            ->willReturn(array());

        $adapterMock->expects($this->once())
            ->method('supports')
            ->willReturn(false);

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->create($subjectMock, $documentMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotComplete()
    {
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array();

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->complete($documentMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotCreateFromFactory()
    {
        $adapterMock = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock);

        $subjectMock = $this->getMock('Subject');

        $translator = new Translator($adapters, $mappingProviderMock);
        $translator->create($subjectMock);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotGetSubjectFromDocument()
    {
        $adapterMock1 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $adapterMock2 = $this->getMock('Textmaster\Translator\Adapter\AdapterInterface');
        $mappingProviderMock = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $adapters = array($adapterMock1, $adapterMock2);

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');

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
