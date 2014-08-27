<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Type
 * @package BW\ModuleBundle\Entity
 */
class Type
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $alias = '';

    /**
     * @var string
     */
    private $property = '';

    /**
     * @var string
     */
    private $formTypeClass = '';

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $widgets;


    /**
     * The constructor
     */
    public function __construct()
    {
        $this->widgets = new ArrayCollection();
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Widget
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Type
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Type
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return string 
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set formTypeClass
     *
     * @param string $formTypeClass
     * @return Type
     */
    public function setFormTypeClass($formTypeClass)
    {
        $this->formTypeClass = $formTypeClass;

        return $this;
    }

    /**
     * Get formTypeClass
     *
     * @return string 
     */
    public function getFormTypeClass()
    {
        return $this->formTypeClass;
    }

    /**
     * Add widgets
     *
     * @param \BW\ModuleBundle\Entity\Widget $widgets
     * @return Type
     */
    public function addWidget(\BW\ModuleBundle\Entity\Widget $widgets)
    {
        $this->widgets[] = $widgets;

        return $this;
    }

    /**
     * Remove widgets
     *
     * @param \BW\ModuleBundle\Entity\Widget $widgets
     */
    public function removeWidget(\BW\ModuleBundle\Entity\Widget $widgets)
    {
        $this->widgets->removeElement($widgets);
    }

    /**
     * Get widgets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidgets()
    {
        return $this->widgets;
    }
}
