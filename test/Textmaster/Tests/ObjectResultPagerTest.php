<?php

namespace Textmaster\Api;

use Textmaster\Model\ProjectInterface;

class ObjectResultPagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveObjectInPagination()
    {
        $allProjects = array(
            'projects' => array(
                array(
                    'name' => 'Project 1',
                    'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
                    'language_from' => 'fr',
                    'language_to' => 'en',
                    'category' => 'C014',
                    'project_briefing' => 'Lorem ipsum...',
                    'options' => array('language_level' => 'premium'),
                    'id' => 1,
                    'status' => ProjectInterface::STATUS_IN_CREATION,
                ),
            ),
            'next_page' => null,
            'previous_page' => null,
        );

        $httpClientMock = $this->getMockBuilder('\Textmaster\HttpClient\HttpClientInterface')
            ->getMock();
        $clientMock = $this->getMockBuilder('\Textmaster\Client')
            ->getMock();
        $clientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $apiMock = $this->getMockBuilder('\Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($allProjects);

        $objectClass = 'Textmaster\Model\Project';
        $resultPager = new \Textmaster\ObjectResultPager($clientMock, 'projects', $objectClass);
        $resultPager->initialize($apiMock, 'all');
        $pagination = $resultPager->getPagination();
        $projects = $pagination['projects'];
        $project = $projects[0];

        $this->assertEquals($objectClass, get_class($project));
        $this->assertEquals(1, $project->getId());
        $this->assertEquals('Project 1', $project->getName());
    }
}
