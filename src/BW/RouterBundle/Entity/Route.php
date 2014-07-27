<?php

namespace BW\RouterBundle\Entity;

/**
 * Class Route
 * @package BW\RouterBundle\Entity
 */
class Route
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $path The query with locale
     */
    private $path = '';

    /**
     * @var string $slug The query without locale
     */
    private $slug = '';

    /**
     * @var array $defaults
     */
    private $defaults = array();


    /**
     * The controller name (a string like BlogBundle:Post:index)
     *
     * @return string
     */
    public function getController()
    {
        return isset($this->defaults['_controller'])
            ? $this->defaults['_controller']
            : null
        ;
    }


    /**
     * The constructor
     */
    public function __construct()
    {
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
     * Set uri
     *
     * @param string $path
     * @return Route
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set query
     *
     * @param string $slug
     * @return Route
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set defaults
     *
     * @param array $defaults
     * @return Route
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Get defaults
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }
}