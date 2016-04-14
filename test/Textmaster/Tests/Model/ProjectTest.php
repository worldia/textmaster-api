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
            'status' => ProjectInterface::STATUS_IN_CREATION,
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
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $project->getStatus());
        $this->assertEquals('fr-fr', $project->getLanguageFrom());
        $this->assertEquals('en-us', $project->getLanguageTo());
        $this->assertEquals('C014', $project->getCategory());
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit\n sed do eiusmod tempor...", $project->getBriefing());
        $this->assertEquals(array('language_level' => 'premium'), $project->getOptions());

        $result = $project->toArray();

        $this->assertEquals($result, $values);
    }

    /**
     * @test
     */
    public function shouldUseSetters()
    {
        $project = new Project();

        $name = 'Project 1';
        $activity = ProjectInterface::ACTIVITY_TRANSLATION;
        $languageFrom = 'fr';
        $languageTo = 'en';
        $category = 'C014';
        $briefing = 'Lorem ipsum...';
        $options = array('language_level' => 'premium');

        $project
            ->setName($name)
            ->setActivity($activity)
            ->setLanguageFrom($languageFrom)
            ->setLanguageTo($languageTo)
            ->setCategory($category)
            ->setBriefing($briefing)
            ->setOptions($options)
        ;

        $this->assertEquals($name, $project->getName());
        $this->assertEquals($activity, $project->getActivity());
        $this->assertEquals($languageFrom, $project->getLanguageFrom());
        $this->assertEquals($languageTo, $project->getLanguageTo());
        $this->assertEquals($category, $project->getCategory());
        $this->assertEquals($briefing, $project->getBriefing());
        $this->assertEquals(array('language_level' => 'premium'), $project->getOptions());
        $this->assertEquals(ProjectInterface::STATUS_IN_CREATION, $project->getStatus());
    }

    /**
     * @test
     * @expectedException \Textmaster\Exception\ObjectImmutableException
     */
    public function shouldBeImmutable()
    {
        $values = array(
            'id' => '123456',
            'name' => 'Project 1',
            'ctype' => ProjectInterface::ACTIVITY_TRANSLATION,
            'status' => ProjectInterface::STATUS_IN_REVIEW,
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

        $project->setName('New name');
    }
}
