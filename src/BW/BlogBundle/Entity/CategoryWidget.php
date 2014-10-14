<?php

namespace BW\BlogBundle\Entity;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Entity\WidgetInterface;
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
}
