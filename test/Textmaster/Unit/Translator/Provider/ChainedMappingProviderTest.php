<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Translator\Provider;

use Textmaster\Exception\MappingNotFoundException;
use Textmaster\Translator\Provider\ChainedMappingProvider;
use Textmaster\Unit\Mock\MockTranslatable;

class ChainedMappingProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetProperties()
    {
        $providerMock1 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providerMock2 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providers = [$providerMock1, $providerMock2];

        $subjectMock = new MockTranslatable();

        $providerMock1->expects($this->once())
            ->method('getProperties')
            ->will($this->throwException(new MappingNotFoundException('value')));

        $providerMock2->expects($this->once())
            ->method('getProperties')
            ->willReturn(['name']);

        $provider = new ChainedMappingProvider($providers);
        $properties = $provider->getProperties($subjectMock);

        $this->assertSame(['name'], $properties);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\MappingNotFoundException
     */
    public function shouldNotGetProperties()
    {
        $providerMock1 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providerMock2 = $this->getMock('Textmaster\Translator\Provider\MappingProviderInterface');
        $providers = [$providerMock1, $providerMock2];

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
