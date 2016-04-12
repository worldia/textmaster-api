<?php

namespace Textmaster\Model;

abstract class TextmasterObject
{
    /**
     * Populate the object with the given array.
     * The format for the array should be propertyName => value.
     *
     * @param array $values
     */
    public function fromArray(array $values)
    {
        $properties = $this->getPropertiesValues();

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

        $properties = $this->getPropertiesValues();
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

        return $values;
    }

    /**
     * Get properties values.
     *
     * @return array
     */
    private function getPropertiesValues()
    {
        $values = array();

        $reflect = new \ReflectionClass($this);
        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            $values[] = $property->getName();
        }

        return $values;
    }
}
