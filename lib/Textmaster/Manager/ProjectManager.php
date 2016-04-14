<?php

namespace Textmaster\Manager;

use Textmaster\Api\Project as ProjectApi;
use Textmaster\Client;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\WorkflowException;
use Textmaster\Model\Project;
use Textmaster\Model\ProjectInterface;
use Textmaster\ObjectResultPager;
use Textmaster\ResultPagerInterface;

class ProjectManager
{
    /**
     * @var ProjectApi
     */
    protected $api;

    /**
     * @var Client
     */
    protected $client;

    /**
     * ProjectManager constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->api = $this->client->api('project');
    }

    /**
     * Create a project from the given parameters.
     *
     * @param string $name
     * @param string $activity
     * @param string $languageFrom
     * @param string $languageTo
     * @param string $category
     * @param string $briefing
     * @param array  $options
     *
     * @return Project
     *
     * @throws InvalidArgumentException
     */
    public function create(
        $name,
        $activity,
        $languageFrom,
        $languageTo,
        $category,
        $briefing,
        array $options
    ) {
        if (!array_key_exists('language_level', $options)) {
            throw new InvalidArgumentException('Cannot create a Project without "language_level" option.');
        }

        $project = new Project();
        $project
            ->setName($name)
            ->setActivity($activity)
            ->setLanguageFrom($languageFrom)
            ->setLanguageTo($languageTo)
            ->setCategory($category)
            ->setBriefing($briefing)
            ->setOptions($options)
        ;

        $result = $this->api->create($project->toArray());

        $project->fromArray($result);

        return $project;
    }

    /**
     * Get a project from its id.
     *
     * @param string $id
     *
     * @return Project
     */
    public function get($id)
    {
        $result = $this->api->show($id);

        $project = new Project();
        $project->fromArray($result);

        return $project;
    }

    /**
     * Update the given project.
     *
     * @param Project $project
     *
     * @return ProjectInterface
     */
    public function update(Project $project)
    {
        $project->failIfImmutable();

        $result = $this->api->update($project->getId(), $project->toArray());
        $project->fromArray($result);

        return $project;
    }

    /**
     * Launch the given project.
     *
     * @param Project $project
     *
     * @return ProjectInterface
     *
     * @throws WorkflowException
     */
    public function launch(Project $project)
    {
        $project->failIfImmutable();

        $result = $this->api->asyncLaunch($project->getId());
        $project->fromArray($result);

        return $project;
    }

    /**
     * Get an object result pager for all documents of the given project.
     *
     * The result is paginated if the count is greater than the max per page value (20).
     *
     * @param Project $project
     *
     * @return ResultPagerInterface
     */
    public function documents(Project $project)
    {
        $resultPager = new ObjectResultPager($this->client, 'documents', '\Textmaster\Model\Document');
        $resultPager->initialize($this->api, 'all', array($project->getId()));

        return $resultPager;
    }

    /**
     * Get an object result pager for projects.
     *
     * @param array $where to filter result
     * @param array $order to order result
     *
     * @return ResultPagerInterface
     */
    public function all(array $where = array(), array $order = array())
    {
        $resultPager = new ObjectResultPager($this->client, 'projects', '\Textmaster\Model\Project');
        if (!empty($where) || !empty($order)) {
            $resultPager->initialize($this->api, 'filter', array($where, $order));
        } else {
            $resultPager->initialize($this->api, 'all');
        }

        return $resultPager;
    }
}
