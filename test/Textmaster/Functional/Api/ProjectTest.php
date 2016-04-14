<?php

namespace Textmaster\Functional\Api;

use Textmaster\Api\Project;
use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    // As launch project is done asynchronously we need a project to be paused and resumed.
    const TEST_PROJECT_ID = '57065757f41f44001100000e';

    /**
     * Project api.
     *
     * @var Project
     */
    protected $api;

    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient(array('base_url' => 'http://api.sandbox.textmaster.com/%s'));
        $httpClient->authenticate('GFHunwb2DHw', 'gqvE7aZS_JM');
        $client = new Client($httpClient);

        $this->api = $client->project();
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
        $where = array(
            'name' => 'worldia_test',
        );
        $result = $this->api->filter($where);

        $this->assertEquals(1, $result['count']);
    }

    /**
     * @test
     */
    public function shouldCreateProject()
    {
        $params = array(
            'name' => 'Created project for functional test',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => array(
                'language_level' => 'premium',
            ),
            'language_from' => 'en',
            'language_to' => 'fr',
            'category' => 'C021',
            'project_briefing' => 'This project is only for testing purpose',
        );

        $result = $this->api->create($params);

        $this->assertEquals('Created project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        return $result['id'];
    }

    /**
     * @test
     * @depends shouldCreateProject
     */
    public function shouldUpdateProject($projectId)
    {
        $params = array(
            'name' => 'Project for functional test',
        );

        $result = $this->api->update($projectId, $params);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        return $result['id'];
    }

    /**
     * @test
     * @depends shouldCreateProject
     */
    public function shouldShowProject($projectId)
    {
        $result = $this->api->show($projectId);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);
    }

    /**
     * @test
     * @depends shouldCreateProject
     */
    public function shouldAddDocument($projectId)
    {
        $params = array(
            'title' => 'Document for functional test',
            'original_content' => 'Text to translate.',
            'word_count' => 3,
        );
        $result = $this->api->documents()->create($projectId, $params);

        $this->assertEquals('Document for functional test', $result['title']);
        $this->assertEquals('Text to translate.', $result['original_content']);
        $this->assertEquals(DocumentInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertEquals($projectId, $result['project_id']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldAddDocument
     */
    public function shouldLaunchProject($projectId)
    {
        $result = $this->api->asyncLaunch($projectId);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldLaunchProject
     */
    public function shouldCancelProject($projectId)
    {
        $result = $this->api->cancel($projectId);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldCancelProject
     */
    public function shouldArchiveProject($projectId)
    {
        $result = $this->api->archive($projectId);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldArchiveProject
     */
    public function shouldUnarchiveProject($projectId)
    {
        $result = $this->api->unarchive($projectId);

        $this->assertEquals('Project for functional test', $result['name']);
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertEquals('premium', $result['options']['language_level']);
        $this->assertEquals('en', $result['language_from']);
        $this->assertEquals('fr', $result['language_to']);
        $this->assertEquals('C021', $result['category']);
        $this->assertEquals('This project is only for testing purpose', $result['project_briefing']);
        $this->assertEquals(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertEquals('api', $result['creation_channel']);

        $this->api->archive($projectId);
    }

    /**
     * @test
     */
    public function shouldPauseProject()
    {
        $result = $this->api->pause(self::TEST_PROJECT_ID);

        $this->assertEquals('worldia_test', $result['name']);
        $this->assertEquals('fr', $result['language_from']);
        $this->assertEquals('en', $result['language_to']);
        $this->assertEquals(ProjectInterface::STATUS_PAUSED, $result['status']);
    }

    /**
     * @test
     */
    public function shouldResumeProject()
    {
        $result = $this->api->resume(self::TEST_PROJECT_ID);

        $this->assertEquals('worldia_test', $result['name']);
        $this->assertEquals('fr', $result['language_from']);
        $this->assertEquals('en', $result['language_to']);
        $this->assertEquals(ProjectInterface::STATUS_IN_PROGRESS, $result['status']);
    }

    /**
     * @test
     */
    public function shouldQuoteProject()
    {
        $params = array(
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'options' => array(
                'language_level' => 'premium',
            ),
            'language_from' => 'fr-fr',
            'language_to' => 'en-us',
            'total_word_count' => 4000,
        );

        $totalCosts = array(
            0 => array(
                'currency' => 'EUR',
                'amount' => 240,
            ),
            1 => array(
                'currency' => 'credits',
                'amount' => 240000,
            ),
        );

        $result = $this->api->quote($params);

        $this->assertEquals('fr', $result['language_from']);
        $this->assertEquals('en', $result['language_to']);
        $this->assertEquals(4000, $result['total_word_count']);
        $this->assertEquals($totalCosts, $result['total_costs']);
    }
}
