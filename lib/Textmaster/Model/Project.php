<?php

namespace Textmaster\Model;

use Pagerfanta\Pagerfanta;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\PagerfantaAdapter;

class Project extends AbstractObject implements ProjectInterface
{
    /**
     * @var \Textmaster\Api\Project
     */
    protected $api;

    /**
     * @var string
     */
    protected $apiName = 'project';

    /**
     * {@inheritdoc}
     */
    protected function getCreationStatus()
    {
        return ProjectInterface::STATUS_IN_CREATION;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->failIfImmutable();
        $this->data['name'] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivity()
    {
        return $this->data['ctype'];
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity($activity)
    {
        $this->failIfImmutable();

        if (!in_array($activity, self::getAllowedActivities())) {
            throw new InvalidArgumentException(sprintf(
                'Activity must me one of "%s".',
                implode('","', self::getAllowedActivities())
            ));
        }

        $this->data['ctype'] = $activity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllowedActivities()
    {
        return array(
            ProjectInterface::ACTIVITY_COPYWRITING,
            ProjectInterface::ACTIVITY_PROOFREADING,
            ProjectInterface::ACTIVITY_TRANSLATION,
        );
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
    public function getLanguageFrom()
    {
        return $this->data['language_from'];
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageFrom($language)
    {
        $this->failIfImmutable();
        $this->data['language_from'] = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguageTo()
    {
        return $this->data['language_to'];
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageTo($language)
    {
        $this->failIfImmutable();
        $this->data['language_to'] = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->data['category'];
    }

    /**
     * {@inheritdoc}
     */
    public function setCategory($code)
    {
        $this->failIfImmutable();
        $this->data['category'] = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBriefing()
    {
        return $this->data['project_briefing'];
    }

    /**
     * {@inheritdoc}
     */
    public function setBriefing($briefing)
    {
        $this->failIfImmutable();
        $this->data['project_briefing'] = $briefing;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->data['options'];
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->failIfImmutable();
        $this->data['options'] = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function isImmutable()
    {
        return $this->data['status'] !== self::STATUS_IN_CREATION;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocuments(array $where = array(), array $order = array())
    {
        $adapter = new PagerfantaAdapter($this->api->documents($this->getId()), $where, $order);

        return new Pagerfanta($adapter);
    }

    /**
     * {@inheritdoc}
     */
    public function createDocument($originalContent, $title = null, $instructions = null)
    {
        $this->failIfImmutable();
        $this->failIfUnsaved();

        $document = new Document($this->client, array('project_id' => $this->getId()));
        $document
            ->setOriginalContent($originalContent)
            ->setTitle($title)
            ->setInstructions($instructions);
        $document->save();

        return $document;
    }

    /**
     * {@inheritdoc}
     */
    public function launch()
    {
        $this->failIfImmutable();
        $this->failIfUnsaved();

        $this->data = $this->api->launch($this->getId());

        return $this;
    }

    /**
     * Fail if unsaved.
     *
     * @throws BadMethodCallException
     */
    private function failIfUnsaved()
    {
        if (null === $this->getId()) {
            throw new BadMethodCallException('Project is unsaved.');
        }
    }
}
