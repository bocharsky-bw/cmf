<?php

namespace BW\ModuleBundle\Form\DataTransformer;

use BW\ModuleBundle\Entity\Field;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class ArrayToCollectionTransformer
 * @package BW\ModuleBundle\Form\DataTransformer
 */
class ArrayToCollectionTransformer implements DataTransformerInterface
{
    /**
     * @param array $array
     * @return ArrayCollection
     */
    public function transform($array)
    {
        $array = (array)$array; // type casting to array

        $collection = new ArrayCollection();

        foreach ($array as $item) {
            $field = new Field();

            $field->setChild($item['child']);
            $field->setType($item['type']);
            $field->setOptions(json_encode($item['options'], JSON_UNESCAPED_UNICODE));

            $collection->add($field);
        }

        return $collection;
    }

    /**
     * @param ArrayCollection $collection
     * @return array
     */
    public function reverseTransform($collection)
    {
        if ( ! $collection) {
            return array();
        }

        try {
            // Transform each element to array
            $collection = $collection->map(function($element){
                return $element->toArray();
            });
        } catch(\Exception $e) {
            throw new TransformationFailedException(sprintf(''
                . 'An array collection to array transforming is failed with error: '
                . $e->getMessage()
            ));
        }

        return $collection->toArray();
    }
}
