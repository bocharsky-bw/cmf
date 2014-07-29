<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
