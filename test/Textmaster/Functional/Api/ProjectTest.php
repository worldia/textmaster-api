<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Functional\Api;

use Textmaster\Api\Project;
use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Wait time between calls because the sandbox environment is not as fast as prod.
     */
    const WAIT_TIME = 3;

    /**
     * Unique ID used for created project name.
     *
     * @var string
     */
    private static $testId;

    /**
     * Project api.
     *
     * @var Project
     */
    protected $api;

    /**
     * Generate a unique ID when tests starts.
     */
    public static function setUpBeforeClass()
    {
        self::$testId = uniqid();
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient(
            'GFHunwb2DHw',
            'gqvE7aZS_JM',
            ['base_uri' => 'http://api.sandbox.textmaster.com/%s']
        );
        $client = new Client($httpClient);
        $this->api = $client->project();
    }

    /**
     * Cancel and archive projects created during tests.
     */
    public static function tearDownAfterClass()
    {
        sleep(self::WAIT_TIME);

        $httpClient = new HttpClient(
            'GFHunwb2DHw',
            'gqvE7aZS_JM',
            ['base_uri' => 'http://api.sandbox.textmaster.com/%s']
        );
        $client = new Client($httpClient);
        $api = $client->project();

        $where = [
            'name' => self::$testId,
            'status' => ['$in' => [ProjectInterface::STATUS_IN_PROGRESS, ProjectInterface::STATUS_IN_CREATION]],
            'archived' => false,
        ];

        $result = $api->filter($where);
        if (is_array($result)) {
            foreach ($result as $data) {
                if (!is_array($data)) {
                    continue;
                }
                foreach ($data as $project) {
                    self::spinCall($api, 'cancel', $project['id']);
                    self::spinCall($api, 'archive', $project['id']);
                }
            }
        }
    }

    /**
     * @test
     */
    public function shouldShowProjects()
    {
        $result = $this->api->all();

        $this->assertGreaterThan(0, $result['count']);
    }

    /**
     * @test
     */
    public function shouldShowProjectsFiltered()
    {
        $where = [
            'name' => 'worldia_test',
        ];
        $result = $this->api->filter($where);

        $this->assertSame(1, $result['count']);
    }

    /**
     * @test
     */
    public function shouldCreateProject()
    {
        $params = [
            'name' => 'Created project for functional test',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => [
                'language_level' => 'premium',
            ],
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C021',
            'project_briefing' => 'This project is only for testing purpose',
            'work_template' => '1_title_2_paragraphs',
            'textmasters' => [
                '55c3763e656462000b000027'
            ],
        ];

        $result = $this->api->create($params);

        $this->assertSame('Created project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
        $this->assertSame('1_title_2_paragraphs', $result['work_template']['name']);
        $this->assertSame(['55c3763e656462000b000027'], $result['textmasters']);

        return $result['id'];
    }

    /**
     * @test
     */
    public function shouldCreateProjectWithEmptyTextmasters()
    {
        $params = [
            'name' => 'Created project for functional test',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => [
                'language_level' => 'premium',
            ],
            'language_from' => 'fr',
            'language_to' => 'en',
            'category' => 'C021',
            'project_briefing' => 'This project is only for testing purpose',
            'work_template' => '1_title_2_paragraphs',
            'textmasters' => [],
        ];

        $result = $this->api->create($params);

        $this->assertSame('Created project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
        $this->assertSame('1_title_2_paragraphs', $result['work_template']['name']);
        $this->assertSame([], $result['textmasters']);

        return $result['id'];
    }

    /**
     * @test
     */
    public function shouldNotCreateInvalidProject()
    {
        $params = [
            'name' => 'Created project for functional test',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => [
                'language_level' => 'foobar',
            ],
            'language_from' => 'en',
            'language_to' => 'fr',
            'category' => 'C021',
        ];

        $this->setExpectedExceptionRegExp(\LogicException::class, '/"level_name":\["doit être rempli\(e\)"\]/');
        $this->api->create($params);
    }

    /**
     * @test
     * @depends shouldCreateProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldUpdateProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_CREATION);

        $params = [
            'name' => self::$testId,
        ];

        $result = $this->api->update($projectId, $params);

        $this->assertSame(self::$testId, $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $result['id'];
    }

    /**
     * @test
     * @depends shouldCreateProject
     *
     * @param string $projectId
     */
    public function shouldShowProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_CREATION);

        $result = $this->api->show($projectId);

        $this->assertSame(self::$testId, $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
    }

    /**
     * @test
     * @depends shouldCreateProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldAddDocument($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_CREATION);

        $params = [
            'title' => 'Document for functional test',
            'original_content' => 'Text to translate.',
            'word_count' => 3,
            'project_id' => $projectId,
        ];
        $result = $this->api->documents($projectId)->create($params);

        $this->assertSame('Document for functional test', $result['title']);
        $this->assertSame('Text to translate.', $result['original_content']);
        $this->assertSame(DocumentInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame($projectId, $result['project_id']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldAddDocument
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldLaunchProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_CREATION);

        $result = $this->api->launch($projectId);

        $this->assertSame(self::$testId, $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldLaunchProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldPauseProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_PROGRESS);

        $result = $this->api->pause($projectId);

        $this->assertSame(ProjectInterface::STATUS_PAUSED, $result['status']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldPauseProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldResumeProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_PAUSED);

        $result = $this->api->resume($projectId);

        $this->assertSame(ProjectInterface::STATUS_IN_PROGRESS, $result['status']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldResumeProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldCancelProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_IN_PROGRESS);

        $result = $this->api->cancel($projectId);

        $this->assertSame(self::$testId, $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldCancelProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldArchiveProject($projectId)
    {
        $this->waitForStatus($projectId, ProjectInterface::STATUS_CANCELED);

        $result = $this->api->archive($projectId);

        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldArchiveProject
     *
     * @param string $projectId
     *
     * @return string
     */
    public function shouldUnarchiveProject($projectId)
    {
        sleep(self::WAIT_TIME);
        $result = $this->api->unarchive($projectId);

        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);

        return $projectId;
    }

    /**
     * @test
     */
    public function shouldQuoteProject()
    {
        $params = [
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => [
                'language_level' => 'premium',
            ],
            'language_from' => 'fr-fr',
            'language_to' => 'en-us',
            'total_word_count' => 4001,
        ];

        $totalCosts = [
            0 => [
                'currency' => 'EUR',
                'amount' => 240.06,
            ],
            1 => [
                'currency' => 'credits',
                'amount' => 240060,
            ],
        ];

        $result = $this->api->quote($params);

        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame(4001, $result['total_word_count']);
        $this->assertSame($totalCosts, $result['total_costs']);
    }

    /**
     * @param Project $api
     * @param string  $method    method to call
     * @param string  $projectId
     */
    private static function spinCall(Project $api, $method, $projectId)
    {
        $maxRetry = 5;
        $retry = 0;

        while ($retry <= $maxRetry) {
            try {
                $api->$method($projectId);

                return;
            } catch (\LogicException $e) {
                if ($maxRetry < $retry) {
                    throw $e;
                }
            }
            sleep(self::WAIT_TIME);
            ++$retry;
        }
    }

    /**
     * @param string $projectId
     * @param string $status
     */
    private function waitForStatus($projectId, $status)
    {
        $maxRetry = 10;
        $retry = 0;

        while ($retry <= $maxRetry) {
            $result = $this->api->show($projectId);
            if ($status === $result['status']) {
                return;
            }
            printf('[Expected status %s, found %s] ', $status, $result['status']);
            sleep(self::WAIT_TIME);
            ++$retry;
        }

        throw new \RuntimeException(sprintf('Status %s not found for project %s', $status, $projectId));
    }
}
