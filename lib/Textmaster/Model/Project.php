<?php

namespace Textmaster\Model;

use Pagerfanta\Pagerfanta;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\PagerfantaAdapter;

class Project extends AbstractObject implements ProjectInterface
{
    /**
     * @var array
     */
    protected $data = array(
        'status' => ProjectInterface::STATUS_IN_CREATION,
    );

    /**
     * @var array
     */
    protected $immutableProperties = array(
        'name',
        'ctype',
        'category',
        'language_from',
        'language_to',
        'project_briefing',
        'options',
    );

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
        return $this->setProperty('name', $name);
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
        return $this->setProperty('language_from', $language);
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
        return $this->setProperty('language_to', $language);
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
        return $this->setProperty('category', $code);
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
        return $this->setProperty('project_briefing', $briefing);
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
        return $this->setProperty('options', $options);
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
    public function getActivity()
    {
        return $this->data['ctype'];
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity($activity)
    {
        $activities = self::getAllowedActivities();
        if (!in_array($activity, $activities)) {
            throw new InvalidArgumentException(sprintf(
                'Activity must me one of "%s".',
                implode('","', $activities)
            ));
        }

        return $this->setProperty('ctype', $activity);
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
    public function getDocuments(array $where = array(), array $order = array())
    {
        return new Pagerfanta(new PagerfantaAdapter($this->getApi()->documents($this->getId()), $where, $order));
    }

    /**
     * {@inheritdoc}
     */
    public function createDocument()
    {
        if (null === $this->getId()) {
            throw new BadMethodCallException('The project must be saved before adding documents.');
        }

        return new Document($this->client, array('project_id' => $this->getId()));
    }

    /**
     * {@inheritdoc}
     */
    public function launch()
    {
        if ($this->isImmutable() || null === $this->getId()) {
            throw new BadMethodCallException(
                'The project cannot be launched because it has not been saved or is immutable.'
            );
        }

        $this->data = $this->getApi()->launch($this->getId());

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
      * Get the Project Api object.
      *
      * @return \Textmaster\Api\Project
      */
     protected function getApi()
     {
         return $this->client->projects();
     }
}
