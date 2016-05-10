<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api;

class AuthorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllAuthors()
    {
        $expectedArray = array(
            'authors' => array(
                array('ident' => 'A-7B1E-FM', 'id' => '53d7bf6353ecaaf8aa00001e'),
                array('ident' => 'A-7B2E-FM', 'id' => '53d7bf6353ecaaf8aa00002e'),
            ),
            'total_pages' => 0,
            'count' => 2,
            'page' => 1,
            'per_page' => 20,
            'previous_page' => null,
            'next_page' => null,
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/authors')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->find(array(
            'language_from' => 'fr-FR',
            'language_to' => 'de-DE',
        )));
    }

    /**
     * @test
     * @expectedException Textmaster\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionWhenSearchingWithInvalidParameter()
    {
        $this->getApiMock()->find(array('invalid_parameters' => 'value'));
    }

    /**
     * @test
     */
    public function shouldGetMyAuthorsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\Author\Mine', $api->mine());
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Author';
    }
}
