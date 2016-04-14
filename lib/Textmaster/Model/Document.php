<?php

namespace Textmaster\Model;

use Textmaster\Api\Project as ProjectApi;
use Textmaster\Client;
use Textmaster\Exception\InvalidArgumentException;

class Document extends AbstractObject implements DocumentInterface
{
    /**
     * Constructor.
     *
     * @param Client $client the Textmaster client.
     * @param array  $data   the id of the object or an array value to populate it.
     */
    public function __construct(Client $client, array $data)
    {
        if (!array_key_exists('project_id', $data)) {
            throw new InvalidArgumentException('Cannot create Document without project_id.');
        }
        if (1 === count($data)) {
            $data['status'] = $this->getCreationStatus();
        }

        $this->data = $data;
        $this->client = $client;
        /** @var ProjectApi $api */
        $api = $client->api('projects');
        $this->api = $api->documents($data['project_id']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCreationStatus()
    {
        return DocumentInterface::STATUS_IN_CREATION;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return new Project($this->client, $this->data['project_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->data['title'];
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->failIfImmutable();
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstructions()
    {
        return $this->data['instructions'];
    }

    /**
     * {@inheritdoc}
     */
    public function setInstructions($instructions)
    {
        $this->failIfImmutable();
        $this->data['instructions'] = $instructions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalContent()
    {
        return $this->data['original_content'];
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalContent($content)
    {
        $this->failIfImmutable();
        $this->data['original_content'] = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslatedContent()
    {
        return $this->data['translated_content'];
    }

    /**
     * {@inheritdoc}
     */
    protected function isImmutable()
    {
        return $this->data['status'] !== self::STATUS_IN_CREATION;
    }
}
