<?php

namespace BW\ModuleBundle\Service;

/**
 * Interface WidgetServiceInterface
 * @package BW\ModuleBundle\Service
 */
interface WidgetServiceInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function render();
}
