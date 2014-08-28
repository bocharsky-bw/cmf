<?php

namespace BW\MenuBundle\Entity;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Entity\WidgetInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * MenuWidget
 */
class MenuWidget implements WidgetInterface
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
     * @var \BW\MenuBundle\Entity\Menu
     */
    private $menu;


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
     * @return MenuWidget
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
     * Set menu
     *
     * @param \BW\MenuBundle\Entity\Menu $menu
     * @return MenuWidget
     */
    public function setMenu(Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \BW\MenuBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
