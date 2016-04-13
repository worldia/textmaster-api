<?php

namespace Textmaster\Model;

use Textmaster\Exception\ObjectImmutableException;

abstract class AbstractObject
{
    /**
     * Map TM properties to object properties where name is different.
     * TM => PHP.
     *
     * @var array
     */
    protected $propertyMap = array();

    /**
     * Populate the object with the given array.
     * The format for the array should be propertyName => value.
     *
     * @param array $values
     */
    public function fromArray(array $values)
    {
        $properties = $this->getProperties();

        foreach ($this->propertyMap as $source => $destination) {
            $values[$destination] = $values[$source];
            unset($values[$source]);
        }

        foreach ($values as $key => $value) {
            $property = lcfirst(implode('', array_map(function ($key) {
                return ucfirst($key);
            }, explode('_', $key))));

            if (!in_array($property, $properties)) {
                continue;
            }

            $this->$property = $value;
        }
    }

    /**
     * Generate an array from the object.
     *
     * @return array $values
     */
    public function toArray()
    {
        $values = array();

        $properties = $this->getProperties();
        foreach ($properties as $property) {
            if (null === $this->$property) {
                continue;
            }

            $underscored = strtolower(
                preg_replace(
                    array('/([A-Z]+)/', '/_([A-Z]+)([A-Z][a-z])/'),
                    array('_$1', '_$1_$2'),
                    lcfirst($property)
                )
            );

            $values[$underscored] = $this->$property;
        }

        foreach ($this->propertyMap as $source => $destination) {
            $values[$source] = $values[$destination];
            unset($values[$destination]);
        }

        return $values;
    }

    /**
     * Fail if immutable.
     *
     * @throws ObjectImmutableException
     */
    public function failIfImmutable()
    {
        if (!$this->isImmutable()) {
            return;
        }

        throw new ObjectImmutableException(sprintf(
            'Object of class "%s" with id "%s" is immutable.',
            get_called_class(),
            property_exists($this, 'id') ? $this->id : 'unknown'
        ));
    }

    /**
     * Whether the object is immutable.
     *
     * @return bool
     */
    abstract public function isImmutable();

    /**
     * Get properties.
     *
     * @return array
     */
    private function getProperties()
    {
        $values = array();

        $reflect = new \ReflectionClass($this);
        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            if ($property->getName() === 'propertyMap') {
                continue;
            }
            $values[] = $property->getName();
        }

        return $values;
    }
}
