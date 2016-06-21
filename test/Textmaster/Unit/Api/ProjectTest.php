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

class ProjectTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllProjects()
    {
        $expectedArray = [
            ['id' => 1, 'name' => 'Test project 1'],
            ['id' => 2, 'name' => 'Test project 2'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldFilterProjects()
    {
        $expectedArray = [
            ['id' => 1, 'name' => 'Test project 1'],
            ['id' => 2, 'name' => 'Test project 2'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/filter')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->filter(['name' => 'Test']));
    }

    /**
     * @test
     */
    public function shouldShowProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->show(1));
    }

    /**
     * @test
     */
    public function shouldCreateProjectWithoutTracker()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->create(['name' => 'Test project']));
    }

    /**
     * @test
     */
    public function shouldCreateProjectWithTracker()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->create(['name' => 'Test project'], 12345));
    }

    /**
     * @test
     */
    public function shouldUpdateProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->update(1, ['name' => 'Test project'], 12345));
    }

    /**
     * @test
     */
    public function shouldCancelProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/cancel')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->cancel(1));
    }

    /**
     * @test
     */
    public function shouldArchiveProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/archive')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->archive(1));
    }

    /**
     * @test
     */
    public function shouldUnarchiveProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/unarchive')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->unarchive(1));
    }

    /**
     * @test
     */
    public function shouldPauseProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/pause')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->pause(1));
    }

    /**
     * @test
     */
    public function shouldResumeProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/resume')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->resume(1));
    }

    /**
     * @test
     */
    public function shouldLaunchProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/async_launch')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->launch(1));
    }

    /**
     * @test
     */
    public function shouldQuoteProject()
    {
        $expectedArray = ['id' => 1, 'name' => 'Test project'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/quotation')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->quote(['words' => 320]));
    }

    /**
     * @test
     */
    public function shouldGetDocumentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\Project\Document', $api->documents(1));
    }

    /**
     * @test
     */
    public function shouldGetAuthorsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Textmaster\Api\Project\Author', $api->authors(1));
    }

    protected function getApiClass()
    {
        return 'Textmaster\Api\Project';
    }
}
