<?php

namespace Textmaster\Model;

use Textmaster\Api\ObjectApiInterface;
use Textmaster\Client;
use Textmaster\Exception\BadMethodCallException;
use Textmaster\Exception\ObjectImmutableException;

abstract class AbstractObject
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiName;

    /**
     * @var ObjectApiInterface
     */
    protected $api;

    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     *
     * @param Client $client the Textmaster client.
     * @param mixed  $data   the id of the object or an array value to populate it.
     */
    public function __construct(Client $client, $data = null)
    {
        $this->client = $client;
        /** @var ObjectApiInterface $api */
        $api = $client->api($this->apiName);
        $this->api = $api;

        if (null === $data) {
            $data = array('status' => $this->getCreationStatus());
        } elseif (!is_array($data)) {
            $data = $this->api->show($data);
        }

        $this->data = $data;
    }

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        if (array_key_exists('id', $this->data)) {
            return $this->data['id'];
        }

        return;
    }

    /**
     * Save the object through API.
     *
     * @return AbstractObject
     */
    public function save()
    {
        try {
            $this->getId() ? $this->update() : $this->create();
        } catch (BadMethodCallException $e) {
            throw new BadMethodCallException(sprintf(
                "You can't %s %s objects.",
                $this->getId() ? 'update' : 'create',
                get_called_class()
            ));
        }
    }

    /**
     * Update the object through API.
     *
     * @return AbstractObject
     */
    protected function update()
    {
        $this->data = $this->api->update($this->getId(), $this->data);

        return $this;
    }

    /**
     * Create the object through API.
     *
     * @return AbstractObject
     */
    protected function create()
    {
        $this->data = $this->api->create($this->data);

        return $this;
    }

    /**
     * Fail if immutable.
     *
     * @throws ObjectImmutableException
     */
    protected function failIfImmutable()
    {
        if (!$this->isImmutable()) {
            return;
        }

        throw new ObjectImmutableException(sprintf(
            'Object of class "%s" with id "%s" is immutable.',
            get_called_class(),
            $this->getId() ? $this->getId() : 'unknown'
        ));
    }

    /**
     * Whether the object is immutable.
     *
     * @return bool
     */
    abstract protected function isImmutable();

    /**
     * The object status at creation.
     *
     * @return string
     */
    abstract protected function getCreationStatus();
}
