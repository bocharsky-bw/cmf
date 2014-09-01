<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Field
 * @package BW\ModuleBundle\Entity
 */
class Field
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string The field name
     */
    private $child = '';

    /**
     * @var string The field type
     */
    private $type = '';

    /**
     * @var string The JSON string of options
     */
    private $options = '';


    /**
     * The constructor
     */
    public function __construct()
    {
    }

    /**
     * Transform current object to array
     *
     * @return array
     */
    public function toArray()
    {
//        var_dump($this->getType()); die;
        return array(
            'child' => $this->getChild(),
            'type' => $this->getType(),
            'options' => json_decode($this->getOptions(), true),
        );
    }


    /* SETTERS / GETTERS */

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param string $child
     */
    public function setChild($child)
    {
        $this->child = (string)$child;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $type = (string)$type;
        $this->type = $type ? $type : null;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $options
     */
    public function setOptions($options)
    {
        $options = (string)$options;
        // Transform empty array to null
        if ('[]' === $options) {
            $options = null;
        }
        $this->options = $options ? $options : '{}';
    }
}
