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

use Textmaster\Api\Author;
use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Wait time between calls because the sandbox environment is not as fast as prod.
     */
    const WAIT_TIME = 3;

    /**
     * Author api.
     *
     * @var Author
     */
    protected $api;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient('GFHunwb2DHw', 'gqvE7aZS_JM',
            ['base_uri' => 'http://api.sandbox.textmaster.com/%s']);
        $client = new Client($httpClient);
        $this->api = $client->author();
    }

    /**
     * @test
     */
    public function shouldShowAuthors()
    {
        $result = $this->api->mine()->all();

        $this->assertGreaterThan(0, $result['count']);
    }

    /**
     * @test
     */
    public function shouldShowAuthorsFiltered()
    {
        $status = 'my_textmaster';

        $result = $this->api->mine()->all($status);

        $this->assertGreaterThan(0, $result['count']);

        foreach ($result['my_authors'] as $author) {
            $this->assertSame($author['status'], $status);
        }
    }
}
