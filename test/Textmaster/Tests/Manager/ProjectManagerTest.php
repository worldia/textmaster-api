<?php

namespace Textmaster\Tests\Manager;

use Textmaster\Manager\ProjectManager;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;

class ProjectManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateProject()
    {
        $expectedArray = array(
            'name' => 'Project 1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('create'))
            ->getMock();
        $apiMock->method('create')
            ->willReturn($expectedArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $project = $manager->create(
            'Project 1',
            ProjectInterface::ACTIVITY_TRANSLATION,
            'fr',
            'en',
            'C014',
            'Lorem ipsum...',
            array('language_level' => 'premium')
        );

        $this->assertEquals('Textmaster\Model\Project', get_class($project));
        $this->assertEquals('Project 1', $project->getName());
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $project->getActivity());
        $this->assertEquals('fr', $project->getLanguageFrom());
        $this->assertEquals('en', $project->getLanguageTo());
        $this->assertEquals('C014', $project->getCategory());
        $this->assertEquals('Lorem ipsum...', $project->getBriefing());
        $this->assertEquals(array('language_level' => 'premium'), $project->getOptions());
        $this->assertEquals(1, $project->getId());
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $project->getStatus());
    }

    /**
     * @test
     */
    public function shouldGetProject()
    {
        $expectedArray = array(
            'name' => 'Project 1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('show'))
            ->getMock();
        $apiMock->method('show')
            ->willReturn($expectedArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $project = $manager->get(1);

        $this->assertEquals('Project 1', $project->getName());
    }

    /**
     * @test
     */
    public function shouldUpdateProject()
    {
        $createArray = array(
            'name' => 'Project 1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $expectedArray = array(
            'name' => 'New project Name',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('show', 'update'))
            ->getMock();
        $apiMock->method('show')
            ->willReturn($createArray);
        $apiMock->method('update')
            ->willReturn($expectedArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $project = $manager->get(1);

        $project->setName('New project Name');
        $updatedProject = $manager->update($project);

        $this->assertEquals('New project Name', $updatedProject->getName());
    }

    /**
     * @test
     */
    public function shouldLaunchProject()
    {
        $createArray = array(
            'name' => 'Project1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $expectedArray = array(
            'name' => 'Project1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('show', 'asyncLaunch'))
            ->getMock();
        $apiMock->method('show')
            ->willReturn($createArray);
        $apiMock->method('asyncLaunch')
            ->willReturn($expectedArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $project = $manager->get(1);

        $launchedProject = $manager->launch($project);

        $this->assertEquals($project->getName(), $launchedProject->getName());
    }

    /**
     * @test
     */
    public function shouldGetProjectDocuments()
    {
        $createArray = array(
            'name' => 'Project1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options' => array('language_level' => 'premium'),
            'id' => 1,
            'status' => ProjectInterface::STATUS_IN_CREATION,
        );

        $documentsArray = array(
            'documents' => array(
                array(
                    'id' => '123456',
                    'title' => 'Document 1',
                    'status' => DocumentInterface::STATUS_IN_CREATION,
                    'original_content' => 'Text to translate.',
                    'translated_content' => 'Texte à traduire.',
                    'project_id' => '123456',
                ),
            ),
            'previous_page' => null,
            'next_page' => null,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('show', 'all'))
            ->getMock();
        $apiMock->method('show')
            ->willReturn($createArray);
        $apiMock->method('all')
            ->willReturn($documentsArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $project = $manager->get(1);

        $pagerResult = $manager->documents($project);

        $this->assertEquals('Textmaster\ObjectResultPager', get_class($pagerResult));
    }

    /**
     * @test
     */
    public function shouldGetAllProjects()
    {
        $projectsArray = array(
            'projects' => array(
                array('id' => '12'),
                array('id' => '34'),
                array('id' => '56'),
            ),
            'previous_page' => null,
            'next_page' => null,
        );

        $apiMock = $this->getMockBuilder('Textmaster\Api\ApiInterface')
            ->setMethods(array('all'))
            ->getMock();
        $apiMock->method('all')
            ->willReturn($projectsArray);

        $clientMock = $this->getMockBuilder('Textmaster\Client')
            ->getMock();
        $clientMock->method('api')
            ->willReturn($apiMock);

        $manager = new ProjectManager($clientMock);
        $pagerResult = $manager->all();

        $this->assertEquals('Textmaster\ObjectResultPager', get_class($pagerResult));
    }
}
