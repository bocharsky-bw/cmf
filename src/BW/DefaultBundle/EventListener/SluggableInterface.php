<?php

namespace BW\DefaultBundle\EventListener;

/**
 * Interface SluggableInterface
 * @package BW\DefaultBundle\Service
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