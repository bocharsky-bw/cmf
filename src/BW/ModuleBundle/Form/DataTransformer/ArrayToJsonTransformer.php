<?php

namespace BW\ModuleBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class ArrayToJsonTransformer
 * @package BW\ModuleBundle\Form\DataTransformer
 */
class ArrayToJsonTransformer implements DataTransformerInterface
{
    /**
     * @param array $array
     * @return string
     */
    public function transform($array)
    {
        if ( ! is_array($array)) {
            $array = array();
        }
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $json
     * @return array
     */
    public function reverseTransform($json)
    {
        if ( ! $json) {
            return array();
        }

        try {
            $array = json_decode($json, true);
        } catch(\Exception $e) {
            throw new TransformationFailedException(sprintf(''
                . 'An array to json transforming is failed with error: '
                . $e->getMessage()
            ));
        }

        return $array;
    }
}
