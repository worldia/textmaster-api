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

use Symfony\Component\EventDispatcher\GenericEvent;
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
    final protected function update()
    {
        $this->data = $this->getApi()->update($this->getId(), $this->data);
        $this->dispatchEvent($this->data);

        return $this;
    }

    /**
     * Create the object through API.
     *
     * @return AbstractObject
     */
    final protected function create()
    {
        $this->data = $this->getApi()->create($this->data);
        $this->dispatchEvent($this->data);

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
        if ($this->isImmutable() && in_array($property, $this->immutableProperties, true)) {
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
     * Get property if exists.
     *
     * @param string $property
     *
     * @return mixed
     */
    protected function getProperty($property)
    {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        }

        return;
    }

    /**
     * Dispatch an event.
     *
     * @param array $data Optional data to dispatch with the event.
     */
    protected function dispatchEvent(array $data = array())
    {
        $name = $this->getEventNamePrefix().'.'.$this->getStatus();

        $event = new GenericEvent($this, $data);

        $this->client->getEventDispatcher()->dispatch($name, $event);
    }

    /**
     * Get dispatched event name prefix from model class.
     *
     * @return string
     */
    abstract protected function getEventNamePrefix();

    /**
     * Get object status.
     *
     * @return string
     */
    abstract protected function getStatus();

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
