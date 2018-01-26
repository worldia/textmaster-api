<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Model;

use Textmaster\Api\FilterableApiInterface;
use Textmaster\Api\Project as ApiProject;
use Textmaster\Client;
use Textmaster\Model\AuthorInterface;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\Project;
use Textmaster\Model\ProjectInterface;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    protected $clientMock;
    protected $projectApiMock;

    public function setUp()
    {
        parent::setUp();

        $showValues = [
            'id'                 => '123456',
            'name'               => 'Project 1',
            'status'             => ProjectInterface::STATUS_IN_CREATION,
            'ctype'              => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from'      => 'fr',
            'language_to'        => 'en',
            'category'           => 'C014',
            'project_briefing'   => 'Lorem ipsum...',
            'options'            => ['language_level' => 'premium'],
            'textmasters'        => ['55c3763e656462000b000027'],
            'documents_statuses' => [
                'in_creation'        => 0,
                'waiting_assignment' => 2,
                'in_progress'        => 0,
                'in_review'          => 0,
                'incomplete'         => 0,
                'completed'          => 0,
                'paused'             => 0,
                'canceled'           => 0,
                'quality_control'    => 0,
                'copyscape'          => 0,
                'counting_words'     => 1,
            ],
        ];
        $updateValues = [
            'id'               => '123456',
            'name'             => 'Project Beta',
            'status'           => ProjectInterface::STATUS_IN_CREATION,
            'ctype'            => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from'    => 'fr',
            'language_to'      => 'en',
            'category'         => 'C014',
            'project_briefing' => 'Lorem ipsum...',
            'options'          => ['language_level' => 'premium'],
            'textmasters'      => ['55c3763e656462000b000027'],
        ];

        $authors = [
            'total_pages'   => 1,
            'count'         => 1,
            'page'          => 1,
            'per_page'      => 20,
            'previous_page' => null,
            'next_page'     => null,
            'my_authors'    => [
                [
                    'description'     => '',
                    'tags'            => [],
                    'status'          => 'my_textmaster',
                    'id'              => '5743286d28cf7f00031eb4c9',
                    'author_id'       => '55c3763e656462000b000027',
                    'author_ref'      => 'A-3727-TM',
                    'author_name'     => 'Test',
                    'latest_activity' => '2017-02-06 16:42:03 UTC',
                    'created_at'      => [
                        'day'   => 23,
                        'month' => 5,
                        'year'  => 2016,
                        'full'  => '2016-05-23 15:57:33 UTC',
                    ],
                    'updated_at'      => [
                        'day'   => 6,
                        'month' => 2,
                        'year'  => 2017,
                        'full'  => '2017-02-06 14:06:41 UTC',
                    ]
                ]
            ]
        ];

        $clientMock = $this->createPartialMock(Client::class, ['api']);
        $projectApiMock = $this->createPartialMock(
            ApiProject::class,
            ['show', 'update', 'launch', 'authors', 'documents'],
            [$clientMock]
        );
        $documentApiMock = $this->createPartialMock(FilterableApiInterface::class, ['filter', 'getClient']);
        $projectAuthorApiMock = $this->createPartialMock(
            'Textmaster\Api\Project\Author',
            ['all'],
            [$clientMock, 123456]
        );

        $clientMock->method('api')
            ->willReturn($projectApiMock);

        $projectApiMock->method('show')
            ->willReturn($showValues);

        $projectApiMock->method('update')
            ->willReturn($updateValues);

        $projectApiMock->method('documents')
            ->willReturn($documentApiMock);

        $projectApiMock->method('authors')
            ->willReturn($projectAuthorApiMock);

        $projectAuthorApiMock->method('all')
            ->willReturn($authors);

        $this->clientMock = $clientMock;
        $this->projectApiMock = $projectApiMock;
    }

    /**
     * @test
     */
    public function shouldCreateEmpty()
    {
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = ['language_level' => 'premium'];
        $callback = [ProjectInterface::CALLBACK_PROJECT_IN_PROGRESS => 'http://callback.url'];
        $textmasters = ['55c3763e656462000b000027'];

        $project = new Project($this->clientMock);
        $project
            ->setName($name)
            ->setActivity($activity)
            ->setLanguageFrom($languageFrom)
            ->setLanguageTo($languageTo)
            ->setCategory($category)
            ->setBriefing($briefing)
            ->setOptions($options)
            ->setCallback($callback)
            ->setTextmasters($textmasters);

        $this->assertNull($project->getId());
        $this->assertSame($name, $project->getName());
        $this->assertSame($status, $project->getStatus());
        $this->assertSame($activity, $project->getActivity());
        $this->assertSame($languageFrom, $project->getLanguageFrom());
        $this->assertSame($languageTo, $project->getLanguageTo());
        $this->assertSame($category, $project->getCategory());
        $this->assertSame($briefing, $project->getBriefing());
        $this->assertSame($options, $project->getOptions());
        $this->assertSame($callback, $project->getCallback());
        $this->assertSame($textmasters, $project->getTextmasters());
    }

    /**
     * @test
     */
    public function shouldCreateFromValues()
    {
        $id = '123456';
        $name = 'Project 1';
        $status = ProjectInterface::STATUS_IN_CREATION;
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = ['language_level' => 'premium'];
        $textmasters = ['55c3763e656462000b000027'];
        $documentsStatuses = [
            'in_creation'        => 0,
            'waiting_assignment' => 2,
            'in_progress'        => 0,
            'in_review'          => 0,
            'incomplete'         => 0,
            'completed'          => 0,
            'paused'             => 0,
            'canceled'           => 0,
            'quality_control'    => 0,
            'copyscape'          => 0,
            'counting_words'     => 1,
        ];

        $values = [
            'id'                 => $id,
            'name'               => $name,
            'status'             => $status,
            'ctype'              => $activity,
            'language_from'      => $languageFrom,
            'language_to'        => $languageTo,
            'category'           => $category,
            'project_briefing'   => $briefing,
            'options'            => $options,
            'textmasters'        => $textmasters,
            'documents_statuses' => $documentsStatuses,
        ];

        $project = new Project($this->clientMock, $values);

        $this->assertSame($id, $project->getId());
        $this->assertSame($name, $project->getName());
        $this->assertSame($status, $project->getStatus());
        $this->assertSame($activity, $project->getActivity());
        $this->assertSame($languageFrom, $project->getLanguageFrom());
        $this->assertSame($languageTo, $project->getLanguageTo());
        $this->assertSame($category, $project->getCategory());
        $this->assertSame($briefing, $project->getBriefing());
        $this->assertSame($options, $project->getOptions());
        $this->assertSame($textmasters, $project->getTextmasters());
        $this->assertEquals(2, $project->getDocumentsStatuses()[DocumentInterface::STATUS_WAITING_ASSIGNMENT]);
        $this->assertEquals(1, $project->getDocumentsStatuses()[DocumentInterface::STATUS_COUNTING_WORDS]);
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $name = 'Project 1';

        $project = new Project($this->clientMock, '123456');

        $this->assertSame($name, $project->getName());

        $project->setName('Project Beta');
        $project->save();

        $this->assertSame('Project Beta', $project->getName());
    }

    /**
     * @test
     */
    public function shouldGetPotentialAuthors()
    {
        $project = new Project($this->clientMock, '123456');
        $authors = $project->getPotentialAuthors();

        $this->assertInternalType('array', $authors);
        $this->assertCount(1, $authors);

        foreach ($authors as $author) {
            $this->assertInstanceOf(AuthorInterface::class, $author);
            $this->assertSame('55c3763e656462000b000027', $author->getAuthorId());
        }
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\BadMethodCallException
     */
    public function shouldNotGetPotentialAuthorsOnUnsaved()
    {
        $project = new Project($this->clientMock);
        $project->getPotentialAuthors();
    }

    /**
     * @test
     */
    public function shouldGetDocuments()
    {
        $project = new Project($this->clientMock, '123456');
        $pager = $project->getDocuments();

        $this->assertSame('Pagerfanta\Pagerfanta', get_class($pager));
    }

    /**
     * @test
     */
    public function shouldCreateDocument()
    {
        $project = new Project($this->clientMock, '123456');
        $document = $project->createDocument();

        $this->assertSame('Textmaster\Model\Document', get_class($document));
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $document->getStatus());
    }

    /**
     * @test
     */
    public function shouldGetAllowedActivities()
    {
        $allowedActivities = [
            ProjectInterface::ACTIVITY_COPYWRITING,
            ProjectInterface::ACTIVITY_PROOFREADING,
            ProjectInterface::ACTIVITY_TRANSLATION,
        ];

        $this->assertSame($allowedActivities, Project::getAllowedActivities());
    }

    /**
     * @test
     */
    public function shouldLaunch()
    {
        $this->projectApiMock->expects($this->once())
            ->method('launch')
            ->willReturn([]);

        $project = new Project($this->clientMock, '123456');
        $project->launch();
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $values = [
            'id'     => 'ID-IMMUTABLE',
            'status' => ProjectInterface::STATUS_IN_PROGRESS,
        ];

        $project = new Project($this->clientMock, $values);
        $project->setName('New name');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotSetWrongActivity()
    {
        $project = new Project($this->clientMock, '123456');
        $project->setActivity('wrong activity name');
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\BadMethodCallException
     */
    public function shouldNotCreateDocumentOnUnsaved()
    {
        $project = new Project($this->clientMock);
        $project->createDocument();
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\InvalidArgumentException
     */
    public function shouldNotSetWrongCallback()
    {
        $project = new Project($this->clientMock, '123456');
        $project->setCallback(['wrong_callback' => 'bad value']);
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\BadMethodCallException
     */
    public function shouldNotLaunchImmutable()
    {
        $values = [
            'id'     => 'ID-IMMUTABLE',
            'status' => ProjectInterface::STATUS_IN_PROGRESS,
        ];

        $project = new Project($this->clientMock, $values);
        $project->launch();
    }
}
