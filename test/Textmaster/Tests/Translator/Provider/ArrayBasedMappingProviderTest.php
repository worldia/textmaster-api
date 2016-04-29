<?php

namespace Textmaster\Tests\Translator\Provider;

use Textmaster\Tests\Mock\MockTranslatable;
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
            'Textmaster\Tests\Mock\MockTranslatable' => array('name'),
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
            'Textmaster\Tests\Mock\WrongClass' => array('name'),
        );

        $provider = new ArrayBasedMappingProvider($mappings);
        $provider->getProperties($subjectMock);
    }
}
