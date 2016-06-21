<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
class Project extends AbstractApi implements ObjectApiInterface, FilterableApiInterface
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
     * @param array $where
     * @param array $order
     *
     * @return array
     */
    public function filter(array $where = [], array $order = [])
    {
        $params = [];

        empty($where) ?: $params['where'] = json_encode($where);
        empty($order) ?: $params['order'] = json_encode($order);

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
     * @param array $params
     *
     * @return array
     */
    public function create(array $params)
    {
        return $this->post($this->getPath(), ['project' => $params]);
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
     *
     * @param string $projectId
     *
     * @return array
     */
    public function launch($projectId)
    {
        return $this->post($this->getPath($projectId).'/async_launch');
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
        return $this->get($this->getPath().'/quotation', ['project' => $params]);
    }

    /**
     * Documents Api.
     *
     * @param string $projectId
     *
     * @return Document
     */
    public function documents($projectId)
    {
        return new Document($this->client, $projectId);
    }

    /**
     * Authors Api.
     *
     * @param string $projectId
     *
     * @return ProjectAuthors
     */
    public function authors($projectId)
    {
        return new ProjectAuthors($this->client, $projectId);
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
