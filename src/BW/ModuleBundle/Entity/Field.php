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
     * @var string
     */
    private $child = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $options = '';


    /**
     * The constructor
     */
    public function __construct()
    {
    }

    public function __toString()
    {
        return 'fields to json transform...';
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
        $this->child = $child;
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
        $this->type = $type;
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
        $this->options = $options;
    }
}
