<?php

namespace Textmaster\Tests\Model;

use Textmaster\Model\Document;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\Project;
use Textmaster\Model\ProjectInterface;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array(), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $project = new Project($clientMock);
        $project
            ->setName($name)
            ->setActivity($activity)
            ->setLanguageFrom($languageFrom)
            ->setLanguageTo($languageTo)
            ->setCategory($category)
            ->setBriefing($briefing)
            ->setOptions($options)
        ;

        $this->assertNull($project->getId());
        $this->assertEquals($name, $project->getName());
        $this->assertEquals($status, $project->getStatus());
        $this->assertEquals($activity, $project->getActivity());
        $this->assertEquals($languageFrom, $project->getLanguageFrom());
        $this->assertEquals($languageTo, $project->getLanguageTo());
        $this->assertEquals($category, $project->getCategory());
        $this->assertEquals($briefing, $project->getBriefing());
        $this->assertEquals($options, $project->getOptions());
    }

    /**
     * @test
     */
    public function shouldCreateFromValues()
    {
        $id = 1;
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $values = array(
            'id' => $id,
            'name' => $name,
            'status' => $status,
            'ctype' => $activity,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
            'category' => $category,
            'project_briefing' => $briefing,
            'options' => $options,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array(), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $project = new Project($clientMock, $values);

        $this->assertEquals($id, $project->getId());
        $this->assertEquals($name, $project->getName());
        $this->assertEquals($status, $project->getStatus());
        $this->assertEquals($activity, $project->getActivity());
        $this->assertEquals($languageFrom, $project->getLanguageFrom());
        $this->assertEquals($languageTo, $project->getLanguageTo());
        $this->assertEquals($category, $project->getCategory());
        $this->assertEquals($briefing, $project->getBriefing());
        $this->assertEquals($options, $project->getOptions());
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $id = 1;
        $name = 'Project Alpha';
        $newName = 'Project Beta';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $values = array(
            'id' => $id,
            'name' => $newName,
            'status' => $status,
            'ctype' => $activity,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
            'category' => $category,
            'project_briefing' => $briefing,
            'options' => $options,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array('update'), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $apiMock->method('update')
            ->willReturn($values);

        $values['name'] = $name;
        $project = new Project($clientMock, $values);

        $this->assertEquals($id, $project->getId());
        $this->assertEquals($name, $project->getName());
        $this->assertEquals($status, $project->getStatus());
        $this->assertEquals($activity, $project->getActivity());
        $this->assertEquals($languageFrom, $project->getLanguageFrom());
        $this->assertEquals($languageTo, $project->getLanguageTo());
        $this->assertEquals($category, $project->getCategory());
        $this->assertEquals($briefing, $project->getBriefing());
        $this->assertEquals($options, $project->getOptions());

        $project->setName($newName);
        $project->save();

        $this->assertEquals($id, $project->getId());
        $this->assertEquals($newName, $project->getName());
        $this->assertEquals($status, $project->getStatus());
        $this->assertEquals($activity, $project->getActivity());
        $this->assertEquals($languageFrom, $project->getLanguageFrom());
        $this->assertEquals($languageTo, $project->getLanguageTo());
        $this->assertEquals($category, $project->getCategory());
        $this->assertEquals($briefing, $project->getBriefing());
        $this->assertEquals($options, $project->getOptions());
    }

    /**
     * @test
     */
    public function shouldGetDocuments()
    {
        $id = 1;
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $values = array(
            'id' => $id,
            'name' => $name,
            'status' => $status,
            'ctype' => $activity,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
            'category' => $category,
            'project_briefing' => $briefing,
            'options' => $options,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\FilterableApiInterface', array('filter'));

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $project = new Project($clientMock, $values);
        $pager = $project->getDocuments();

        $this->assertEquals('Pagerfanta\Pagerfanta', get_class($pager));
    }

    /**
     * @test
     */
    public function shouldCreateDocument()
    {
        $id = 1;
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $documentValues = array(
            'id' => '123456',
            'title' => 'Document 1',
            'status' => DocumentInterface::STATUS_IN_CREATION,
            'project_id' => $id,
        );

        $values = array(
            'id' => $id,
            'name' => $name,
            'status' => $status,
            'ctype' => $activity,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
            'category' => $category,
            'project_briefing' => $briefing,
            'options' => $options,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $projectApiMock = $this->getMock('Textmaster\Api\Project', array('documents'), array($clientMock));
        $documentApiMock = $this->getMock('Textmaster\Api\Document', array('create'));

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $documentApiMock->method('create')
            ->willReturn($documentValues);

        $project = new Project($clientMock, $values);
        $document = $project->createDocument('Document 1');

        $this->assertEquals('Textmaster\Model\Document', get_class($document));
        $this->assertEquals('Document 1', $document->getTitle());
        $this->assertEquals('123456', $document->getId());
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $id = 1;
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_PROGRESS;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $values = array(
            'id' => $id,
            'name' => $name,
            'status' => $status,
            'ctype' => $activity,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
            'category' => $category,
            'project_briefing' => $briefing,
            'options' => $options,
        );

        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array(), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $project = new Project($clientMock, $values);

        $project->setName('New name');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotSetWrongActivity()
    {
        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array(), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $project = new Project($clientMock);
        $project->setActivity('wrong activity name');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\BadMethodCallException
     */
    public function shouldNotCreateDocumentOnUnsaved()
    {
        $clientMock = $this->getMock('Textmaster\Client', array('api'));
        $apiMock = $this->getMock('Textmaster\Api\Project', array(), array($clientMock));

        $clientMock->method('api')
            ->willReturn($apiMock);

        $project = new Project($clientMock);
        $project->createDocument('Original content.');
    }

    /**
     * @test
     */
    public function shouldGetAllowedActivities()
    {
        $allowedActivities = array(
            ProjectInterface::ACTIVITY_COPYWRITING,
            ProjectInterface::ACTIVITY_PROOFREADING,
            ProjectInterface::ACTIVITY_TRANSLATION,
        );
        $this->assertEquals($allowedActivities, Project::getAllowedActivities());
    }
}
