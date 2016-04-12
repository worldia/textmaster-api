<?php

namespace Textmaster\Api;

use Textmaster\Api\Project\Author as ProjectAuthors;
use Textmaster\Api\Project\Document;

/**
 * Projects Api.
 *
 * @link   https://fr.textmaster.com/documentation#projects-archive-a-project
 *
 * @author Christian Daguerre <christian@daguer.re>
 */
class Project extends AbstractApi
{
    /**
     * List all projects.
     *
     * @link https://www.textmaster.com/documentation#projects-listing-all-projects
     *
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath());
    }

    /**
     * Filter projects.
     *
     * @link https://fr.textmaster.com/documentation#projects-filtering-projects
     *
     * @return array
     */
    public function filter(array $params)
    {
        return $this->get($this->getPath().'/filter', $params);
    }

    /**
     * Show a single project.
     *
     * @link https://www.textmaster.com/documentation#projects-get-a-project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function show($projectId)
    {
        return $this->get($this->getPath($projectId));
    }

    /**
     * Create a project.
     *
     * @link https://www.textmaster.com/documentation#projects-create-a-project
     *
     * @param array       $params
     * @param string|null $tracker
     *
     * @return array
     */
    public function create(array $params, $tracker = null)
    {
        $params = array(
            'project' => $params,
        );

        if (null !== $tracker) {
            $params['tracker'] = $tracker;
        }

        return $this->post($this->getPath(), $params);
    }

    /**
     * Update a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-update-a-project
     *
     * @param string $projectId
     * @param array  $params
     *
     * @return array
     */
    public function update($projectId, array $params)
    {
        return $this->put($this->getPath($projectId), $params);
    }

    /**
     * Cancel a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-cancel-a-project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function cancel($projectId)
    {
        return $this->put($this->getPath($projectId).'/cancel');
    }

    /**
     * Archive a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-archive-a-project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function archive($projectId)
    {
        return $this->put($this->getPath($projectId).'/archive');
    }

    /**
     * Unarchive a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-unarchive-a-project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function unarchive($projectId)
    {
        return $this->put($this->getPath($projectId).'/unarchive');
    }

    /**
     * Pause a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-pause-a-project
     *
     * @param string $projectId
     *
     * @return array
     */
    public function pause($projectId)
    {
        return $this->put($this->getPath($projectId).'/pause');
    }

    /**
     * Resume a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-resume-a-project-after-pause
     *
     * @param string $projectId
     *
     * @return array
     */
    public function resume($projectId)
    {
        return $this->put($this->getPath($projectId).'/resume');
    }

    /**
     * Launch a project.
     *
     * @link https://www.textmaster.com/documentation#projects-launch-a-project-asynchronously
     * @link https://www.textmaster.com/documentation#projects-launch-a-project
     * @deprecated Synchronously launching a project is deprecated
     *
     * @param string $projectId
     * @param bool   $async
     *
     * @return array
     */
    public function launch($projectId, $async = true)
    {
        if ($async) {
            return $this->post($this->getPath($projectId).'/async_launch');
        }

        return $this->put($this->getPath($projectId).'/launch');
    }

    /**
     * Get quotation for a project.
     *
     * @link https://fr.textmaster.com/documentation#projects-get-quotation-for-a-project
     *
     * @param array $params
     *
     * @return array
     */
    public function quote(array $params)
    {
        return $this->get($this->getPath().'/quotation', array('project' => $params));
    }

    /**
     * Documents Api.
     *
     * @return Document
     */
    public function documents()
    {
        return new Document($this->client);
    }

    /**
     * Authors Api.
     *
     * @return ProjectAuthors
     */
    public function authors()
    {
        return new ProjectAuthors($this->client);
    }

    /**
     * Get api path.
     *
     * @param null|string $projectId
     *
     * @return string
     */
    protected function getPath($projectId = null)
    {
        if (null !== $projectId) {
            return sprintf('clients/projects/%s', rawurlencode($projectId));
        }

        return 'clients/projects';
    }
}
