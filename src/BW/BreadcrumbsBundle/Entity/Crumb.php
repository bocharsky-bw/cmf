<?php

namespace BW\BreadcrumbsBundle\Entity;

/**
 * Class Crumb
 * @package BW\BreadcrumbsBundle\Entity
 */
class Crumb
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $uri;


    /**
     * @param string $name
     * @param string $uri
     */
    public function __construct($name = null, $uri = null)
    {
        $this->setName($name);
        $this->setUri($uri);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param $uri
     *
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = (string)$uri;

        return $this;
    }
}