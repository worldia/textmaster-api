<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster;

use Pagerfanta\Adapter\AdapterInterface;
use Textmaster\Api\FilterableApiInterface;
use Textmaster\Exception\InvalidArgumentException;

class PagerfantaAdapter implements AdapterInterface
{
    /**
     * @var FilterableApiInterface
     */
    protected $api;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var array
     */
    protected $order;

    /**
     * @var bool
     */
    protected $asObjects;

    /**
     * Class map in the form of 'resource_name' => 'Object class'.
     *
     * @var array
     */
    protected $classes = array(
      'projects' => 'Textmaster\Model\Project',
      'documents' => 'Textmaster\Model\Document',
    );

    /**
     * PagerfantaAdapter constructor.
     *
     * @param FilterableApiInterface $api
     * @param array                  $where
     * @param array                  $order
     * @param bool                   $asObjects
     */
    public function __construct(FilterableApiInterface $api, array $where = array(), array $order = array(), $asObjects = true)
    {
        $this->api = $api;
        $this->where = $where;
        $this->order = $order;
        $this->asObjects = $asObjects;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        $result = $this->api->filter($this->where, $this->order);

        return (int) $result['count'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        $result = $this->api->setPerPage($length)->setPage($offset)->filter($this->where, $this->order);

        $resource = $this->guessResource($result);

        if ($this->asObjects) {
            return $this->toObjects($result, $resource);
        }

        return $result[$resource];
    }

    /**
     * Guess resource from API result.
     *
     * @param array $result
     *
     * @return string
     */
    private function guessResource(array $result)
    {
        if (isset($result['projects'])) {
            return 'projects';
        }
        if (isset($result['documents'])) {
            return 'documents';
        }

        throw new InvalidArgumentException(sprintf('Could not guess resource type from "%s".', serialize($result)));
    }

    /**
     * Transform the given array values into object.
     *
     * @param array  $result
     * @param string $resource
     *
     * @return array
     */
    private function toObjects(array $result, $resource)
    {
        $objects = array();
        foreach ($result[$resource] as $values) {
            $object = new $this->classes[$resource]($this->api->getClient(), $values);
            $objects[] = $object;
        }

        return $objects;
    }
}
