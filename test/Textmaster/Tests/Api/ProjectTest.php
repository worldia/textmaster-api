<?php

namespace Textmaster\Tests\Api;

class ProjectTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllProjects()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'Test project 1'),
            array('id' => 2, 'name' => 'Test project 2'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldFilterProjects()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'Test project 1'),
            array('id' => 2, 'name' => 'Test project 2'),
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/filter')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->filter(array('name' => 'Test')));
    }

    /**
     * @test
     */
    public function shouldShowProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show(1));
    }

    /**
     * @test
     */
    public function shouldCreateProjectWithoutTracker()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create(array('name' => 'Test project')));
    }

    /**
     * @test
     */
    public function shouldCreateProjectWithTracker()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create(array('name' => 'Test project'), 12345));
    }

    /**
     * @test
     */
    public function shouldUpdateProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update(1, array('name' => 'Test project'), 12345));
    }

    /**
     * @test
     */
    public function shouldCancelProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/cancel')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->cancel(1));
    }

    /**
     * @test
     */
    public function shouldArchiveProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/archive')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->archive(1));
    }

    /**
     * @test
     */
    public function shouldUnarchiveProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/unarchive')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->unarchive(1));
    }

    /**
     * @test
     */
    public function shouldPauseProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/pause')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->pause(1));
    }

    /**
     * @test
     */
    public function shouldResumeProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('clients/projects/1/resume')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->resume(1));
    }

    /**
     * @test
     */
    public function shouldLaunchProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('clients/projects/1/async_launch')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->launch(1));
    }

    /**
     * @test
     */
    public function shouldQuoteProject()
    {
        $expectedArray = array('id' => 1, 'name' => 'Test project');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/projects/quotation')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->quote(array('words' => 320)));
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
