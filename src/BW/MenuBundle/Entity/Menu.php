<?php

namespace BW\MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 */
class Menu
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
    private $items;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $menuWidgets;


    /**
     * The constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->menuWidgets = new ArrayCollection();
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
     * @return Menu
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
     * @return Menu
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Menu
     */
    public function setDescription($description)
    {
        $this->description = isset($description) ? $description : '';

        return $this;
    }

    /**
     * Add items
     *
     * @param \BW\MenuBundle\Entity\Item $items
     * @return Menu
     */
    public function addItem(Item $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \BW\MenuBundle\Entity\Item $items
     */
    public function removeItem(Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add menuWidgets
     *
     * @param \BW\MenuBundle\Entity\MenuWidget $menuWidgets
     * @return Menu
     */
    public function addMenuWidget(\BW\MenuBundle\Entity\MenuWidget $menuWidgets)
    {
        $this->menuWidgets[] = $menuWidgets;

        return $this;
    }

    /**
     * Remove menuWidgets
     *
     * @param \BW\MenuBundle\Entity\MenuWidget $menuWidgets
     */
    public function removeMenuWidget(\BW\MenuBundle\Entity\MenuWidget $menuWidgets)
    {
        $this->menuWidgets->removeElement($menuWidgets);
    }

    /**
     * Get menuWidgets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenuWidgets()
    {
        return $this->menuWidgets;
    }
}
