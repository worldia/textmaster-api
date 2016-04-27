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
    // As launch project is done asynchronously we need a project to be paused and archived.
    const TO_PAUSE_PROJECT_ID = '57065757f41f44001100000e';
    const TO_ARCHIVE_PROJECT_ID = '57109f596765d4000c0002df';

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

        $this->assertSame(1, $result['count']);
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

        $this->assertSame('Created project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

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

        $this->assertSame('Project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $result['id'];
    }

    /**
     * @test
     * @depends shouldCreateProject
     */
    public function shouldShowProject($projectId)
    {
        $result = $this->api->show($projectId);

        $this->assertSame('Project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
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
            'project_id' => $projectId,
        );
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
     */
    public function shouldLaunchProject($projectId)
    {
        $result = $this->api->launch($projectId);

        $this->assertSame('Project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_IN_CREATION, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     * @depends shouldLaunchProject
     */
    public function shouldCancelProject($projectId)
    {
        $result = $this->api->cancel($projectId);

        $this->assertSame('Project for functional test', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertSame('api', $result['creation_channel']);

        return $projectId;
    }

    /**
     * @test
     */
    public function shouldArchiveProject()
    {
        $result = $this->api->archive(self::TO_ARCHIVE_PROJECT_ID);

        $this->assertSame('Project to be archived', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
    }

    /**
     * @test
     */
    public function shouldUnarchiveProject()
    {
        $result = $this->api->unarchive(self::TO_ARCHIVE_PROJECT_ID);

        $this->assertSame('Project to be archived', $result['name']);
        $this->assertSame(ProjectInterface::ACTIVITY_TRANSLATION, $result['ctype']);
        $this->assertSame('premium', $result['options']['language_level']);
        $this->assertSame('en', $result['language_from']);
        $this->assertSame('fr', $result['language_to']);
        $this->assertSame('C021', $result['category']);
        $this->assertSame('This project is only for testing purpose', $result['project_briefing']);
        $this->assertSame(ProjectInterface::STATUS_CANCELED, $result['status']);
        $this->assertSame('api', $result['creation_channel']);
    }

    /**
     * @test
     */
    public function shouldPauseProject()
    {
        $result = $this->api->pause(self::TO_PAUSE_PROJECT_ID);

        $this->assertSame('worldia_test', $result['name']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame(ProjectInterface::STATUS_PAUSED, $result['status']);
    }

    /**
     * @test
     */
    public function shouldResumeProject()
    {
        $result = $this->api->resume(self::TO_PAUSE_PROJECT_ID);

        $this->assertSame('worldia_test', $result['name']);
        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame(ProjectInterface::STATUS_IN_PROGRESS, $result['status']);
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
            'total_word_count' => 4001,
        );

        $totalCosts = array(
            0 => array(
                'currency' => 'EUR',
                'amount' => 240.3,
            ),
            1 => array(
                'currency' => 'credits',
                'amount' => 240300,
            ),
        );

        $result = $this->api->quote($params);

        $this->assertSame('fr', $result['language_from']);
        $this->assertSame('en', $result['language_to']);
        $this->assertSame(4001, $result['total_word_count']);
        $this->assertSame($totalCosts, $result['total_costs']);
    }
}
