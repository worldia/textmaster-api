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

use Textmaster\Client;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\InvalidArgumentException;

class Document extends AbstractObject implements DocumentInterface
{
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @var array
     */
    protected $data = array(
        'status' => self::STATUS_IN_CREATION,
        'word_count_rule' => self::WORD_COUNT_RULE_PERCENTAGE,
        'word_count' => 0,
        'custom_data' => array(),
        'type' => self::TYPE_STANDARD,
    );

    /**
     * @var array
     */
    protected $immutableProperties = array(
        'title',
        'instructions',
        'original_content',
        'callback',
        'custom_data',
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
        if (null === $this->project) {
            $this->project = new Project($this->client, $this->data['project_id']);
        }

        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this->setProperty('project_id', $project->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getProperty('title');
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
        return $this->getProperty('instructions');
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
        return $this->getProperty('status');
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalContent()
    {
        return $this->getProperty('original_content');
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalContent($content)
    {
        if (is_array($content)) {
            $this->checkArrayContent($content);
            $this->setProperty('type', self::TYPE_KEY_VALUE);
        } elseif (!is_string($content)) {
            throw new InvalidArgumentException('Original content must be of type "string" or "array".');
        }

        $this->setProperty('original_content', $content);

        $this->countWords();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getProperty('type');
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslatedContent()
    {
        $authorWork = $this->getProperty('author_work');

        if (self::TYPE_STANDARD === $this->getType()) {
            $authorWork = $authorWork['free_text'];
        }

        return $authorWork;
    }

    /**
     * {@inheritdoc}
     */
    public function getWordCount()
    {
        return $this->getProperty('word_count');
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
        $result = array_diff(array_keys($callback), self::getAllowedStatus());
        if (0 < count($result)) {
            throw new InvalidArgumentException(sprintf(
                'Key for array callback should be a document status. Wrong values: %s',
                implode(', ', $result)
            ));
        }

        $this->data['callback'] = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomData($key = null)
    {
        $data = $this->getProperty('custom_data');

        if (null !== $key && isset($data[$key])) {
            return $data[$key];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomData($customData, $key = null)
    {
        if (null !== $key) {
            $customData = array_merge($this->getCustomData() ?: array(), array($key => $customData));
        }

        return $this->setProperty('custom_data', $customData);
    }

    /**
     * {@inheritdoc}
     */
    final public function complete($satisfaction = null, $message = null)
    {
        if (self::STATUS_IN_REVIEW !== $this->getStatus()) {
            throw new BadMethodCallException(sprintf(
                'Can only complete a document in review. Status is "%s".',
                $this->getStatus()
            ));
        }

        $satisfactions = self::getAllowedSatisfaction();
        if (null !== $satisfaction && !in_array($satisfaction, $satisfactions, true)) {
            throw new InvalidArgumentException(sprintf(
                'Satisfaction must me one of "%s".',
                implode('","', $satisfactions)
            ));
        }

        $this->data = $this->getApi()->complete($this->getId(), $satisfaction, $message);
        $this->dispatchEvent($this->data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllowedStatus()
    {
        return array(
            self::STATUS_IN_CREATION,
            self::STATUS_IN_PROGRESS,
            self::STATUS_WAITING_ASSIGNMENT,
            self::STATUS_IN_REVIEW,
            self::STATUS_COMPLETED,
            self::STATUS_INCOMPLETE,
            self::STATUS_PAUSED,
            self::STATUS_CANCELED,
            self::STATUS_COPYSCAPE,
            self::STATUS_COUNTING_WORDS,
            self::STATUS_QUALITY,
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllowedSatisfaction()
    {
        return array(
            self::SATISFACTION_NEGATIVE,
            self::SATISFACTION_NEUTRAL,
            self::SATISFACTION_POSITIVE,
        );
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

    /**
     * {@inheritdoc}
     */
    protected function getEventNamePrefix()
    {
        return 'textmaster.document';
    }

    /**
     * Check the given array respect Textmaster standard for array content.
     *
     * @param array $content
     */
    private function checkArrayContent(array $content)
    {
        foreach ($content as $value) {
            if (!is_array($value) || !array_key_exists('original_phrase', $value)) {
                throw new InvalidArgumentException(
                    'Original content of type "array" must only contains array with key "original_phrase".'
                );
            }
        }
    }

    /**
     * Count words in original content.
     */
    private function countWords()
    {
        if (is_string($this->data['original_content'])) {
            $this->data['word_count'] = $this->count($this->data['original_content']);

            return;
        }

        foreach ($this->data['original_content'] as $value) {
            $this->data['word_count'] += $this->count($value['original_phrase']);
        }
    }

    /**
     * Count words (including numbers) in the given string.
     *
     * @param string $input
     *
     * @return int
     */
    private function count($input)
    {
        $res = preg_split('/\s+/', $input);

        return count($res);
    }
}
