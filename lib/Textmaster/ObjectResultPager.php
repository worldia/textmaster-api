<?php

namespace Textmaster;

use Textmaster\Exception\InvalidArgumentException;

class ObjectResultPager extends ResultPager implements ResultPagerInterface
{
    const ABSTRACT_OBJECT_CLASS = '\Textmaster\Model\AbstractObject';

    /**
     * @var string
     */
    protected $arrayKeyToObject;

    /**
     * @var string
     */
    protected $objectClass;

    /**
     * ObjectResultPager constructor.
     *
     * @param Client $client
     * @param string $arrayKeyToObject
     * @param string $objectClass
     */
    public function __construct(Client $client, $arrayKeyToObject, $objectClass)
    {
        if (!is_subclass_of($objectClass, self::ABSTRACT_OBJECT_CLASS)) {
            throw new InvalidArgumentException(sprintf(
                'Object class must extends "%s"',
                self::ABSTRACT_OBJECT_CLASS
            ));
        }
        parent::__construct($client);

        $this->arrayKeyToObject = $arrayKeyToObject;
        $this->objectClass = $objectClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagination()
    {
        if (array_key_exists($this->arrayKeyToObject, $this->pagination)) {
            $this->pagination[$this->arrayKeyToObject] = $this->toObjects($this->pagination[$this->arrayKeyToObject]);
        }

        return $this->pagination;
    }

    /**
     * Transform the given array values into object.
     *
     * @param array $array
     *
     * @return array
     */
    private function toObjects(array $array)
    {
        $objects = array();
        foreach ($array as $value) {
            $object = new $this->objectClass();
            $object->fromArray($value);
            $objects[] = $object;
        }

        return $objects;
    }
}
