<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Api;

use Textmaster\Api\ApiTemplate;

class ApiTemplateTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowAllTemplates()
    {
        $expectedArray = [
            "api_templates" => [
                "id"                                 => "3734fed3-833b-4e46-8b3b-cf36ccd79afe",
                "name"                               => "Foo Bar 2017-09-06 12:32:02 +0200",
                "description"                        => "[TM] Standard Translation (en-us > fr-fr)",
                "level_name"                         => "premium",
                "activity_name"                      => "translation",
                "language_from"                      => "en-us",
                "language_to"                        => "fr-fr",
                "project_briefing"                   => "Bacon ipsum dolor amet ribeye tenderloin pancetta ground round cow turducken shankle beef ribs.",
                "options"                            => [
                    "language_level" => "premium",
                ],
                "textmasters"                        => [

                ],
                "cost_per_word"                      => [
                    "currency" => "credits",
                    "amount"   => 10,
                ],
                "cost_per_word_in_currency"          => [
                    "currency" => "USD",
                    "amount"   => 0.014,
                ],
                "same_author_must_do_entire_project" => true,
                "auto_launch"                        => true,
                "created_at"                         => [
                    "day"   => 6,
                    "month" => 9,
                    "year"  => 2017,
                    "full"  => "2017-09-06 10:32:02 UTC",
                ],
                "updated_at"                         => [
                    "day"   => 6,
                    "month" => 9,
                    "year"  => 2017,
                    "full"  => "2017-09-06 10:32:02 UTC",
                ],
            ],
            "total_pages"   => 1,
            "count"         => 1,
            "page"          => 1,
            "per_page"      => 20,
            "previous_page" => null,
            "next_page"     => null,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('clients/api_templates')
            ->will($this->returnValue($expectedArray));

        $this->assertSame($expectedArray, $api->all());
    }

    protected function getApiClass()
    {
        return ApiTemplate::class;
    }
}
