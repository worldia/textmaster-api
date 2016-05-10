<?php

namespace Textmaster\Unit\Translator\Provider;

use Textmaster\Exception\MappingNotFoundException;
use Textmaster\Unit\Mock\MockTranslatable;
use Textmaster\Translator\Provider\ChainedMappingProvider;

class ChainedMappingProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetProperties()
    {
        $providerMock1 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providerMock2 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providers = array($providerMock1, $providerMock2);

        $subjectMock = new MockTranslatable();

        $providerMock1->expects($this->once())
            ->method('getProperties')
            ->will($this->throwException(new MappingNotFoundException('value')));

        $providerMock2->expects($this->once())
            ->method('getProperties')
            ->willReturn(array('name'));

        $provider = new ChainedMappingProvider($providers);
        $properties = $provider->getProperties($subjectMock);

        $this->assertSame(array('name'), $properties);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\MappingNotFoundException
     */
    public function shouldNotGetProperties()
    {
        $providerMock1 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providerMock2 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providers = array($providerMock1, $providerMock2);

        $subjectMock = new MockTranslatable();

        $providerMock1->expects($this->once())
            ->method('getProperties')
            ->will($this->throwException(new MappingNotFoundException('value')));

        $providerMock2->expects($this->once())
            ->method('getProperties')
            ->will($this->throwException(new MappingNotFoundException('value')));

        $provider = new ChainedMappingProvider($providers);
        $provider->getProperties($subjectMock);
    }
}
