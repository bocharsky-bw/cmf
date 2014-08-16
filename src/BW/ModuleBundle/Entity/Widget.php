<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use BW\RouterBundle\Entity\Route;
use BW\ModuleBundle\Entity\Position;
use BW\ModuleBundle\Entity\WidgetRoute;

/**
 * Widget
 */
class Widget
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $heading = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var boolean $published
     */
    private $published = true;

    /**
     * @var integer $order
     */
    private $order = 0;

    /**
     * @var boolean $visibility
     */
    private $visibility = true;

    /**
     * @var \BW\ModuleBundle\Entity\Position
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $widgetRoutes;


    public function __construct()
    {
        $this->widgetRoutes = new ArrayCollection();
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
     * Set heading
     *
     * @param string $heading
     * @return Widget
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get heading
     *
     * @return string 
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Widget
     */
    public function setDescription($description)
    {
        $this->description = isset($description) ? $description : '';

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
     * Is published
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Widget
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Widget
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set visibility
     *
     * @param boolean $visibility
     * @return Widget
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return boolean
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set position
     *
     * @param \BW\ModuleBundle\Entity\Position $position
     * @return Widget
     */
    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \BW\ModuleBundle\Entity\Position
     */
    public function getPosition()
    {
        return $this->position;
    }



    /**
     * Add widgetRoutes
     *
     * @param \BW\ModuleBundle\Entity\WidgetRoute $widgetRoutes
     * @return Widget
     */
    public function addWidgetRoute(WidgetRoute $widgetRoutes)
    {
        $this->widgetRoutes[] = $widgetRoutes;

        return $this;
    }

    /**
     * Remove widgetRoutes
     *
     * @param \BW\ModuleBundle\Entity\WidgetRoute $widgetRoutes
     */
    public function removeWidgetRoute(WidgetRoute $widgetRoutes)
    {
        $this->widgetRoutes->removeElement($widgetRoutes);
    }

    /**
     * Get widgetRoutes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidgetRoutes()
    {
        return $this->widgetRoutes;
    }
}
