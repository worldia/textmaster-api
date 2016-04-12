<?php

namespace Textmaster\Model;

use Textmaster\Exception\InvalidArgumentException;

class Project extends AbstractObject implements ProjectInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $activity;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $languageFrom;

    /**
     * @var string
     */
    protected $languageTo;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $briefing;

    /**
     * @var array
     */
    protected $options;

    /**
     * {@inheritdoc}
     */
    protected $propertyMap = array(
        'project_briefing' => 'briefing',
        'ctype' => 'activity'
    );

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->failIfImmutable();
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity($type)
    {
        $this->failIfImmutable();

        if (!in_array($type, self::getAllowedActivitys())) {
            throw new InvalidArgumentException(sprintf(
                'Type must me one of "%s".',
                implode('","', self::getAllowedActivitys())
            ));
        }

        $this->activity = $type;

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
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguageFrom()
    {
        return $this->languageFrom;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageFrom($language)
    {
        $this->failIfImmutable();
        $this->languageFrom = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguageTo()
    {
        return $this->languageTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguageTo($language)
    {
        $this->failIfImmutable();
        $this->languageTo = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategory($code)
    {
        $this->failIfImmutable();
        $this->category = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBriefing()
    {
        return $this->briefing;
    }

    /**
     * {@inheritdoc}
     */
    public function setBriefing($briefing)
    {
        $this->failIfImmutable();
        $this->briefing = $briefing;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->failIfImmutable();
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function isImmutable()
    {
        return $this->status === self::STATUS_IN_CREATION;
    }
}
