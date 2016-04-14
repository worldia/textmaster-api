<?php

namespace Textmaster\Model;

use Textmaster\Client;
use Textmaster\Exception\InvalidArgumentException;

class Document extends AbstractObject implements DocumentInterface
{
    /**
     * @var array
     */
    protected $data = array(
        'status' => DocumentInterface::STATUS_IN_CREATION,
    );

    /**
     * @var array
     */
    protected $immutableProperties = array(
        'title',
        'instructions',
        'original_content',
    );

    /**
     * Constructor.
     *
     * @param Client $client the Textmaster client.
     * @param array  $data   all values to populate document | id and project id to load from API |
     *                       nothing to create an empty document
     */
    public function __construct(Client $client, array $data = array())
    {
        $this->client = $client;

        if (1 < count($data)) {
            $this->data = $data;
        } else {
            $this->data = array_merge($this->data, $data);
        }

        if (2 === count($data) && isset($data['project_id']) && isset($data['id'])) {
            $this->refresh();
        }

        if (isset($data['id']) && !isset($data['project_id'])) {
            throw new InvalidArgumentException('Both the document and project ids are required.');
        }
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
    public function setProject(ProjectInterface $project)
    {
        return $this->setProperty('project_id', $project->getId());
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
        return $this->setProperty('title', $title);
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
        return $this->setProperty('instructions', $instructions);
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
        return $this->setProperty('original_content', $content);
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

    /**
     * Get the Document Api object.
     *
     * @return \Textmaster\Api\Project\Document
     */
    protected function getApi()
    {
        return $this->client->projects()->documents($this->data['project_id']);
    }
}
