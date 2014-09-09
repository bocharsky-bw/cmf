<?php

namespace BW\MenuBundle\Entity;

use BW\RouterBundle\Entity\Route;
use BW\DefaultBundle\Entity\NestedSetInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Item
 * @package BW\MenuBundle\Entity
 */
class Item implements NestedSetInterface
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
    private $uri = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $class = '';

    /**
     * @var boolean
     */
    private $published = true;

    /**
     * @var integer
     */
    private $order = 0;

    /**
     * @var integer
     */
    private $root = null;

    /**
     * @var integer
     */
    private $level = 0;

    /**
     * @var integer
     */
    private $left = 0;

    /**
     * @var integer
     */
    private $right = 0;

    /**
     * @var \BW\MenuBundle\Entity\Menu
     */
    private $menu;

    /**
     * @var \BW\MenuBundle\Entity\Item
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \BW\RouterBundle\Entity\Route
     */
    private $route;


    /**
     * The constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }


    public function __toString()
    {
        return str_repeat('- ', $this->level) . $this->name;
    }


    /**
     * Generate current nested level
     *
     * ORM\PrePersist
     * ORM\PreUpdate
     * @return integer
     */
    public function generateLevel()
    {
        $this->level = 0;
        $parent = $this->getParent();

        while ($parent) {
            $this->level++;
            $parent = $parent->getParent();
        }

        return $this;
    }

    /**
     * Whether URI is internal
     *
     * @return bool
     */
    public function isInternalUri()
    {
        return ! ($this->getUri() && preg_match('@^https?://@', $this->getUri()));
    }

    public function getUriForRequest(Request $request)
    {
        if ($this->isInternalUri()) {
            $path = $this->getRoute()
                ? $this->getRoute()->getPath()
                : $this->getUri()
            ;

            $uri = $request->getUriForPath($path);
        } else {
            $uri = $this->getUri();
        }

        return $uri;
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
     * @return Item
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
     * Set uri
     *
     * @param string $uri
     * @return Item
     */
    public function setUri($uri)
    {
        $this->uri = isset($uri) ? $uri : '';

        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = isset($title) ? $title : '';

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return Item
     */
    public function setClass($class)
    {
        $this->class = isset($class) ? $class : '';

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     * @return Item
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
     * @return Item
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
     * Set root
     *
     * @param integer $root
     * @return Item
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Item
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set left
     *
     * @param integer $left
     * @return Item
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Get left
     *
     * @return integer 
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set right
     *
     * @param integer $right
     * @return Item
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Get right
     *
     * @return integer 
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Set menu
     *
     * @param \BW\MenuBundle\Entity\Menu $menu
     * @return Item
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

    /**
     * Set parent
     *
     * @param \BW\MenuBundle\Entity\Item $parent
     * @return Item
     */
    public function setParent(Item $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \BW\MenuBundle\Entity\Item
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \BW\MenuBundle\Entity\Item $children
     * @return Item
     */
    public function addChild(Item $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \BW\MenuBundle\Entity\Item $children
     */
    public function removeChild(Item $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set route
     *
     * @param \BW\RouterBundle\Entity\Route $route
     * @return Item
     */
    public function setRoute(Route $route = null)
    {
        $this->route = $route;

        if (isset($this->route)) {
            $this->uri = ''; // Clear URI when assign route
        }

        return $this;
    }

    /**
     * Get route
     *
     * @return \BW\RouterBundle\Entity\Route 
     */
    public function getRoute()
    {
        return $this->route;
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
}
