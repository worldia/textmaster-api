<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Model;

use Pagerfanta\Pagerfanta;
use Symfony\Component\EventDispatcher\GenericEvent;
use Textmaster\Events;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;
use Textmaster\Exception\UnexpectedTypeException;
use Textmaster\Pagination\PagerfantaAdapter;

class Project extends AbstractObject implements ProjectInterface
{
    /**
     * @var array
     */
    protected $data = [
        'status' => ProjectInterface::STATUS_IN_CREATION,
    ];

    /**
     * @var array
     */
    protected $immutableProperties = [
        'name',
        'ctype',
        'category',
        'language_from',
        'language_to',
        'project_briefing',
        'options',
        'callback',
        'work_template',
        'textmasters',
    ];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getProperty('name');
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
        return $this->getProperty('language_from');
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
        return $this->getProperty('language_to');
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
        return $this->getProperty('category');
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
        return $this->getProperty('project_briefing');
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
        return $this->getProperty('options');
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
    public function getTextmasters()
    {
        return $this->getProperty('textmasters');
    }

    /**
     * {@inheritdoc}
     */
    public function setTextmasters(array $textmasters)
    {
        return $this->setProperty('textmasters', $textmasters);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllowedActivities()
    {
        return [
            ProjectInterface::ACTIVITY_COPYWRITING,
            ProjectInterface::ACTIVITY_PROOFREADING,
            ProjectInterface::ACTIVITY_TRANSLATION,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getActivity()
    {
        return $this->getProperty('ctype');
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity($activity)
    {
        $activities = self::getAllowedActivities();
        if (!in_array($activity, $activities, true)) {
            throw new InvalidArgumentException(sprintf('Activity must be one of "%s".', implode('","', $activities)));
        }

        return $this->setProperty('ctype', $activity);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllowedCallbacks()
    {
        return [
            self::CALLBACK_PROJECT_IN_PROGRESS,
            self::CALLBACK_PROJECT_MEMORY_COMPLETED,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCallback()
    {
        return $this->getProperty('callback');
    }

    /**
     * {@inheritdoc}
     */
    public function setCallback(array $callback)
    {
        $callbacks = self::getAllowedCallbacks();
        foreach ($callback as $key => $value) {
            if (!in_array($key, $callbacks, true)) {
                throw new InvalidArgumentException(sprintf(
                    'Callback keys must be one of "%s".',
                    implode('","', $callbacks)
                ));
            }
        }

        $this->data['callback'] = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkTemplate()
    {
        return $this->getProperty('work_template');
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkTemplate($template)
    {
        return $this->setProperty('work_template', $template);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getProperty('status');
    }

    /**
     * {@inheritdoc}
     */
    public function getDocuments(array $where = [], array $order = [])
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

        $document = new Document($this->client, ['project_id' => $this->getId()]);
        $document->setProject($this);

        return $document;
    }

    /**
     * {@inheritdoc}
     */
    public function addDocuments(array $documents)
    {
        $data = [];

        foreach ($documents as $key => $document) {
            if (!$document instanceof DocumentInterface) {
                throw new UnexpectedTypeException($document, DocumentInterface::class);
            }

            $documentData = $document->getData();

            if ($documentData['project_id'] !== $this->getId()) {
                throw new InvalidArgumentException(sprintf(
                    'Document "%s" relates to a different project.',
                    serialize($documentData)
                ));
            }

            $data[$key] = $documentData;
        }

        $chunks = array_chunk($data, 100);
        $documents = [];

        foreach ($chunks as $chunk) {
            $documents = array_merge($this->getApi()->documents($this->getId())->batchCreate($chunk), $documents);
        }

        foreach ($documents as $key => $document) {
            $document = new Document($this->client, $document);
            $document->setProject($this);
            $event = new GenericEvent($document, $document->getData());
            $this->client->getEventDispatcher()->dispatch(Events::DOCUMENT_IN_CREATION, $event);
        }

        return $this;
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

    /**
     * {@inheritdoc}
     */
    protected function getEventNamePrefix()
    {
        return 'textmaster.project';
    }
}
