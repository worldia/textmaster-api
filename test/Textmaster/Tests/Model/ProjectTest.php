<?php

namespace Textmaster\Tests\Model;

use Textmaster\Model\Project;
use Textmaster\Model\ProjectInterface;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSerialize()
    {
        $values = array(
            'id' => '123456',
            'name' => 'Project 1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'status' => ProjectInterface::ACTIVITY_TRANSLATION,
            'language_from' => 'fr-fr',
            'language_to' => 'en-us',
            'category' => 'C014',
            'project_briefing' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit\n sed do eiusmod tempor...",
            'options' => array(
                'language_level' => 'premium',
            ),
        );

        $project = new Project();
        $project->fromArray($values);

        $this->assertEquals('123456', $project->getId());
        $this->assertEquals('Project 1', $project->getName());
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $project->getActivity());
        $this->assertEquals(ProjectInterface::ACTIVITY_TRANSLATION, $project->getStatus());
        $this->assertEquals('fr-fr', $project->getLanguageFrom());
        $this->assertEquals('en-us', $project->getLanguageTo());
        $this->assertEquals('C014', $project->getCategory());
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit\n sed do eiusmod tempor...", $project->getBriefing());
        $this->assertEquals(array('language_level' => 'premium'), $project->getOptions());

        $result = $project->toArray();

        $this->assertEquals($result, $values);
    }
}
