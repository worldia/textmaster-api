<?php

namespace Textmaster\Serializer;

use Textmaster\Model\TextmasterObject;

/**
 * Manage transformation for TextmasterObject:
 *  - Serialize -> from TextmasterObject to php array.
 *  - Unserialize -> from php array to TextmasterObject.
 */
class Serializer
{
    /**
     * List of all attributes that should not be serialized.
     *
     * @var array
     */
    private $notSerializedAttributes = array('id', 'textMasterId', 'documents');

    /**
     * Serialize a TextmasterObject to a php array.
     *
     * @param TextmasterObject $object
     *
     * @return array
     */
    public function serialize(TextmasterObject $object)
    {
        $values = array();

        $properties = $this->getPropertiesValues($object);
        foreach ($properties as $property) {
            if (in_array($property, $this->notSerializedAttributes)) {
                continue;
            }

            $getter = 'get'.ucfirst($property);
            $value = $object->$getter();
            if (is_null($value) || is_object($value)) {
                continue;
            }

            $underscored = strtolower(
                preg_replace(
                    ['/([A-Z]+)/', '/_([A-Z]+)([A-Z][a-z])/'],
                    ['_$1', '_$1_$2'],
                    lcfirst($property)
                )
            );

            $values[$underscored] = $value;
        }

        return $values;
    }

    /**
     * Unserialize a php array into a TextmasterObject.
     *
     * @param TextmasterObject $object
     * @param array            $values
     *
     * @return TextmasterObject
     *
     * @throws \Exception
     */
    public function unserialize(TextmasterObject $object, array $values)
    {
        $properties = $this->getPropertiesValues($object);

        foreach ($values as $key => $value) {
            $property = lcfirst(implode('', array_map(function ($key) {
                return ucfirst($key);
            }, explode('_', $key))));

            if (!in_array($property, $properties)) {
                continue;
            }

            $setter = 'set'.ucfirst($property);
            $object->$setter($value);
        }

        return $object;
    }

    /**
     * Get properties values for the given object.
     *
     * @param TextmasterObject $object
     *
     * @return array
     */
    private function getPropertiesValues(TextmasterObject $object)
    {
        $values = array();

        $reflect = new \ReflectionClass($object);
        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            $values[] = $property->getName();
        }

        return $values;
    }
}
