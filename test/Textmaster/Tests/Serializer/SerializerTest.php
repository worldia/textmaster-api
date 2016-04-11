<?php

namespace Textmaster\Tests\Serializer;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSerializeAProject()
    {
        $expectedValues = array(
            'name' => 'factory_project',
            'ctype' => 'proofreading',
            'language_from' => 'fr-fr',
            'language_to' => 'fr-fr',
            'category' => 'C014',
            'project_briefing' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation\n    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in\n    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            'options' => array(
                'language_level' => 'premium',
                'expertise' => '559564bc736f7617da000545',
            ),
        );

        $project = new \Textmaster\Model\Project();
        $project
            ->setName('factory_project')
            ->setCtype('proofreading')
            ->setLanguageFrom('fr-fr')
            ->setLanguageTo('fr-fr')
            ->setCategory('C014')
            ->setProjectBriefing("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation\n    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in\n    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.")
            ->setOptions(array(
                'language_level' => 'premium',
                'expertise' => '559564bc736f7617da000545',
            ))
        ;

        $serializer = new \Textmaster\Serializer\Serializer();
        $values = $serializer->serialize($project);

        $this->assertEquals($expectedValues, $values);
    }

    /**
     * @test
     */
    public function shouldUnserializeAProject()
    {
        $values = array(
            'id' => 123456,
            'name' => 'factory_project',
            'ctype' => 'proofreading',
            'language_from' => 'fr-fr',
            'language_to' => 'fr-fr',
            'category' => 'C014',
            'status' => \Textmaster\Model\ProjectInterface::STATUS_IN_PROGRESS,
            'project_briefing' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation\n    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in\n    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            'options' => array(
                'language_level' => 'premium',
                'expertise' => '559564bc736f7617da000545',
            ),
        );

        $project = new \Textmaster\Model\Project();
        $serializer = new \Textmaster\Serializer\Serializer();
        $project = $serializer->unserialize($project, $values);

        $this->assertEquals($project->getId(), 123456);
        $this->assertEquals($project->getName(), $values['name']);
        $this->assertEquals($project->getCtype(), $values['ctype']);
        $this->assertEquals($project->getLanguageFrom(), $values['language_from']);
        $this->assertEquals($project->getLanguageTo(), $values['language_to']);
        $this->assertEquals($project->getCategory(), $values['category']);
        $this->assertEquals($project->getStatus(), $values['status']);
        $this->assertEquals($project->getProjectBriefing(), $values['project_briefing']);
        $this->assertEquals($project->getOptions(), $values['options']);
    }

    /**
     * @test
     */
    public function shouldSerializeADocument()
    {
        $expectedValues = array(
            'title' => 'Document title',
            'original_content' => 'This content will be translated.',
        );

        $document = new \Textmaster\Model\Document();
        $document
            ->setTitle('Document title')
            ->setOriginalContent('This content will be translated.')
        ;

        $serializer = new \Textmaster\Serializer\Serializer();
        $values = $serializer->serialize($document);

        $this->assertEquals($expectedValues, $values);
    }

    /**
     * @test
     */
    public function shouldUnserializeADocument()
    {
        $values = array(
            'id' => 123456,
            'title' => 'Document title',
            'status' => \Textmaster\Model\Document::STATUS_IN_PROGRESS,
            'original_content' => 'This content will be translated.',
            'translated_content' => 'Ce contenu sera traduit.',
        );

        $document = new \Textmaster\Model\Document();
        $serializer = new \Textmaster\Serializer\Serializer();
        $document = $serializer->unserialize($document, $values);

        $this->assertEquals($document->getId(), 123456);
        $this->assertEquals($document->getTitle(), 'Document title');
        $this->assertEquals($document->getStatus(), \Textmaster\Model\Document::STATUS_IN_PROGRESS);
        $this->assertEquals($document->getOriginalContent(), 'This content will be translated.');
        $this->assertEquals($document->getTranslatedContent(), 'Ce contenu sera traduit.');
    }
}
