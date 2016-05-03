<?php

namespace Textmaster\Tests\Translator;

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
}
