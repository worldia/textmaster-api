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

use Textmaster\Api\Locale;
use Textmaster\Api\Project;
use Textmaster\Client;
use Textmaster\HttpClient\HttpClient;
use Textmaster\Model\DocumentInterface;
use Textmaster\Model\ProjectInterface;

class LocaleTest extends \PHPUnit_Framework_TestCase
{
    /** @var Locale */
    protected $api;

    public function setUp()
    {
        parent::setUp();

        $httpClient = new HttpClient('GFHunwb2DHw', 'gqvE7aZS_JM', ['base_uri' => 'http://api.sandbox.textmaster.com/%s']);
        $client = new Client($httpClient);
        $this->api = $client->locale();
    }

    /**
     * @test
     */
    public function shouldShowAbilities()
    {
        $result = $this->api->abilities('translation', 1);
        
        $this->assertNotEmpty($result);
       
        $data = $result['data'];
        
        $this->assertCount(100, $data);
        
        $firstResult = $data[0];
        
        $this->assertArrayHasKey('id', $firstResult);
        $this->assertArrayHasKey('level_name', $firstResult);
        $this->assertArrayHasKey('language_from', $firstResult);
        $this->assertArrayHasKey('language_to', $firstResult);
        $this->assertArrayHasKey('pricing', $firstResult);
        
        $pricing = $firstResult['pricing'];
        $this->assertArrayHasKey('enterprise', $pricing);
        $this->assertArrayHasKey('priority', $pricing);
        $this->assertArrayHasKey('quality', $pricing);
        $this->assertArrayHasKey('specific_attachment', $pricing);
        $this->assertArrayHasKey('translation_memory', $pricing);
    }
}
