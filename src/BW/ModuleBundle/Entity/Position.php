<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Position
 */
class Position
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
    private $description = '';

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

    public function __toString()
    {
        return $this->getName() . ' (' . $this->getAlias() . ')';
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
     * Set name
     *
     * @param string $name
     * @return Position
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set alias
     *
     * @param string $alias
     * @return Position
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
     * Set description
     *
     * @param string $description
     * @return Position
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add widgets
     *
     * @param \BW\ModuleBundle\Entity\Widget $widgets
     * @return Position
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
