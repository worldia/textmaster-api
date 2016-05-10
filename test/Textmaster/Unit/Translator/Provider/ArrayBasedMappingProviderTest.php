<?php

namespace Textmaster\Unit\Translator\Provider;

use Textmaster\Unit\Mock\MockTranslatable;
use Textmaster\Translator\Provider\ArrayBasedMappingProvider;

class ArrayBasedMappingProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetProperties()
    {
        $subjectMock = new MockTranslatable();
        $mappings = array(
            'Textmaster\Unit\Mock\MockTranslatable' => array('name'),
        );

        $provider = new ArrayBasedMappingProvider($mappings);
        $properties = $provider->getProperties($subjectMock);

        $this->assertSame(array('name'), $properties);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\MappingNotFoundException
     */
    public function shouldNotSetWrongActivity()
    {
        $subjectMock = new MockTranslatable();
        $mappings = array(
            'Textmaster\Unit\Mock\WrongClass' => array('name'),
        );

        $provider = new ArrayBasedMappingProvider($mappings);
        $provider->getProperties($subjectMock);
    }
}
