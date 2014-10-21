<?php

namespace BW\BlogBundle\Entity;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Entity\WidgetInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryWidget
 * @package BW\BlogBundle\Entity
 */
class CategoryWidget implements WidgetInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BW\ModuleBundle\Entity\Widget
     */
    private $widget;

    /**
     * @var boolean
     */
    private $mode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * Set widget
     *
     * @param \BW\ModuleBundle\Entity\Widget $widget
     * @return CategoryWidget
     */
    public function setWidget(Widget $widget = null)
    {
        $this->widget = $widget;

        return $this;
    }

    /**
     * Get widget
     *
     * @return \BW\ModuleBundle\Entity\Widget 
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Set mode
     *
     * @param boolean $mode
     * @return CategoryWidget
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return boolean 
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Add categories
     *
     * @param \BW\BlogBundle\Entity\Category $categories
     * @return CategoryWidget
     */
    public function addCategory(Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \BW\BlogBundle\Entity\Category $categories
     */
    public function removeCategory(Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
