<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Functional;

use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;
use Textmaster\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    const TEST_PROJECT_ID = '57065757f41f44001100000e';
    const TEST_DOCUMENT_ID = '57065d0ef41f44000e00008d';

    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient('GFHunwb2DHw', 'gqvE7aZS_JM', ['base_uri' => 'http://api.sandbox.textmaster.com/%s']);
        $this->client = new Client($httpClient);
    }

    /**
     * @test
     */
    public function shouldShowProject()
    {
        $manager = new Manager($this->client);
        $project = $manager->getProject(self::TEST_PROJECT_ID);

        $this->assertTrue(in_array('Textmaster\Model\ProjectInterface', class_implements($project), true));
    }

    /**
     * @test
     */
    public function shouldCreateProject()
    {
        $manager = new Manager($this->client);
        $project = $manager->getProject();

        $this->assertTrue(in_array('Textmaster\Model\ProjectInterface', class_implements($project), true));
        $this->assertNull($project->getId());
    }

    /**
     * @test
     */
    public function shouldShowProjects()
    {
        $manager = new Manager($this->client);
        $pager = $manager->getProjects();

        $this->assertSame('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertGreaterThan(1, $pager->count());
    }

    /**
     * @test
     */
    public function shouldShowFilteredProjects()
    {
        $where = [
            'name' => 'worldia_test',
        ];

        $manager = new Manager($this->client);
        $pager = $manager->getProjects($where);

        $this->assertSame('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertSame(1, $pager->count());
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

        $this->assertSame('Pagerfanta\Pagerfanta', get_class($pager));
        $this->assertSame(1, $pager->count());
        $this->assertTrue(in_array('Textmaster\Model\DocumentInterface', class_implements($document), true));
    }

    /**
     * @test
     */
    public function shouldGetDocument()
    {
        $manager = new Manager($this->client);
        $document = $manager->getDocument(self::TEST_PROJECT_ID, self::TEST_DOCUMENT_ID);

        $this->assertSame('document_test_1', $document->getTitle());
    }
}
