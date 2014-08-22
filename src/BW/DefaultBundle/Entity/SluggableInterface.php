<?php

namespace BW\DefaultBundle\Entity;

/**
 * Interface SluggableInterface
 * @package BW\DefaultBundle\Entity
 */
interface SluggableInterface
{
    /**
     * @return string
     */
    public function getStringForSlug();

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug);

    /**
     * @return string
     */
    public function getSlug();
}