<?php

namespace Textmaster\Transformer;

use Textmaster\Model\TextMasterObject;

/**
 * Manage transformation for TextMasterObject:
 *  - Serialize -> from TextMasterObject to php array.
 *  - Unserialize -> from php array to TextMasterObject.
 */
class Transformer
{
    /**
     * List of all attributes that should not be serialized.
     *
     * @var array
     */
    private $notSerializedAttributes = array('id', 'textMasterId', 'documents');

    /**
     * Serialize a TextMasterObject to a php array.
     *
     * @param TextMasterObject $object
     *
     * @return array
     */
    public function serialize(TextMasterObject $object)
    {
        if (!is_null($object->getTextMasterId())) {
            $values['id'] = $object->getTextMasterId();
        }

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
     * Unserialize a php array into a TextMasterObject.
     *
     * @param TextMasterObject $object
     * @param array            $values
     *
     * @return TextMasterObject
     *
     * @throws \Exception
     */
    public function unserialize(TextMasterObject $object, array $values)
    {
        if (!array_key_exists('id', $values)) {
            throw new \Exception('Cannot unserialize a TextMasterObject from values without id.');
        }
        $object->setTextMasterId($values['id']);
        unset($values['id']);

        $properties = $this->getPropertiesValues($object);

        foreach ($values as $key => $value) {
            $property = lcfirst(str_replace('_', '', ucwords($key, '_')));
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
     * @param TextMasterObject $object
     *
     * @return array
     */
    private function getPropertiesValues(TextMasterObject $object)
    {
        $reflect = new \ReflectionClass($object);
        $properties = $reflect->getProperties();

        foreach ($properties as $property) {
            $values[] = $property->getName();
        }

        return $values;
    }
}
