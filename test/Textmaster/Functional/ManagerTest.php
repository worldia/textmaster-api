<?php

namespace Textmaster\Functional;

use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;
use Textmaster\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    const TEST_PROJECT_ID = '57065757f41f44001100000e';

    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient(array('base_url' => 'http://api.sandbox.textmaster.com/%s'));
        $httpClient->authenticate('GFHunwb2DHw', 'gqvE7aZS_JM');
        $this->client = new Client($httpClient);
    }

    /**
     * @test
     */
    public function shouldShowProject()
    {
        $manager = new Manager($this->client);
        $project = $manager->getProject(self::TEST_PROJECT_ID);

        $this->assertTrue(in_array('Textmaster\Model\ProjectInterface', class_implements($project)));
    }

    /**
     * @test
     */
    public function shouldCreateProject()
    {
        $manager = new Manager($this->client);
        $project = $manager->getProject();

        $this->assertTrue(in_array('Textmaster\Model\ProjectInterface', class_implements($project)));
        $this->assertNull($project->getId());
    }

    /**
     * @test
     */
    public function shouldShowProjects()
    {
        $manager = new Manager($this->client);
        $pager = $manager->getProjects();

        $this->assertEquals('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertGreaterThan(1, $pager->count());
    }

    /**
     * @test
     */
    public function shouldShowFilteredProjects()
    {
        $where = array(
            'name' => 'worldia_test',
        );

        $manager = new Manager($this->client);
        $pager = $manager->getProjects($where);

        $this->assertEquals('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertEquals(1, $pager->count());
    }

    /**
     * @test
     */
    public function shouldShowDocumentsProject()
    {
        $manager = new Manager($this->client);
        $project = $manager->getProject(self::TEST_PROJECT_ID);
        $pager = $project->getDocuments();
        $documents = $pager->getCurrentPageResults();
        $document = $documents[0];

        $this->assertEquals('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertEquals(1, $pager->count());
        $this->assertTrue(in_array('Textmaster\Model\DocumentInterface', class_implements($document)));
    }
}
