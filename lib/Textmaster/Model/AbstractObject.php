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
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $immutableProperties = array();

    /**
     * Constructor.
     *
     * @param Client $client the Textmaster client.
     * @param mixed  $data   the id of the object or an array value to populate it.
     */
    public function __construct(Client $client, $data = null)
    {
        $this->client = $client;

        if (is_array($data)) {
            $this->data = $data;
        } elseif (is_string($data)) {
            $this->data['id'] = $data;
            $this->refresh();
        }
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

        return $this;
    }

    /**
     * Update the object through API.
     *
     * @return AbstractObject
     */
    protected function update()
    {
        $this->data = $this->getApi()->update($this->getId(), $this->data);

        return $this;
    }

    /**
     * Create the object through API.
     *
     * @return AbstractObject
     */
    protected function create()
    {
        $this->data = $this->getApi()->create($this->data);

        return $this;
    }

    /**
     * Refresh the object through API.
     *
     * @return AbstractObject
     */
    protected function refresh()
    {
        $this->data = $this->getApi()->show($this->getId());

        return $this;
    }

    /**
     * Set the given property and throw an exception if
     * the property is immutable.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @throws ObjectImmutableException
     */
    protected function setProperty($property, $value)
    {
        if ($this->isImmutable() && in_array($property, $this->immutableProperties)) {
            throw new ObjectImmutableException(sprintf(
                'Object of class "%s" with id "%s" is immutable.',
                get_called_class(),
                $this->getId() ? $this->getId() : 'unknown'
            ));
        }

        $this->data[$property] = $value;

        return $this;
    }

    /**
     * Whether the object is immutable.
     *
     * @return bool
     */
    abstract protected function isImmutable();

    /**
     * Get the relating Api object.
     *
     * @return ObjectApiInterface
     */
    abstract protected function getApi();
}
