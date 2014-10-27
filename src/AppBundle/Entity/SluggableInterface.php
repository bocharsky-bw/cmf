<?php

namespace AppBundle\Entity;

/**
 * Interface SluggableInterface
 * @package AppBundle\Entity
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