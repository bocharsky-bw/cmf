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
    private $inversedProperty = '';

    /**
     * @var string
     */
    private $entityClass = '';

    /**
     * @var string
     */
    private $formTypeTemplate = '';

    /**
     * @var string
     */
    private $formTypeClass = '';

    /**
     * @var string
     */
    private $serviceName = '';

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
     * Set inversedProperty
     *
     * @param string $inversedProperty
     * @return Type
     */
    public function setInversedProperty($inversedProperty)
    {
        $this->inversedProperty = $inversedProperty;

        return $this;
    }

    /**
     * Get inversedProperty
     *
     * @return string
     */
    public function getInversedProperty()
    {
        return $this->inversedProperty;
    }

    /**
     * Set entityClass
     *
     * @param string $entityClass
     * @return Type
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get entityClass
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
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
     * Set formTypeTemplate
     *
     * @param string $formTypeTemplate
     * @return Type
     */
    public function setFormTypeTemplate($formTypeTemplate)
    {
        $this->formTypeTemplate = $formTypeTemplate;

        return $this;
    }

    /**
     * Get formTypeTemplate
     *
     * @return string
     */
    public function getFormTypeTemplate()
    {
        return $this->formTypeTemplate;
    }

    /**
     * Set serviceName
     *
     * @param string $serviceName
     * @return Type
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * Get serviceName
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Add widgets
     *
     * @param \BW\ModuleBundle\Entity\Widget $widgets
     * @return Type
     */
    public function addWidget(Widget $widgets)
    {
        $this->widgets[] = $widgets;

        return $this;
    }

    /**
     * Remove widgets
     *
     * @param \BW\ModuleBundle\Entity\Widget $widgets
     */
    public function removeWidget(Widget $widgets)
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
