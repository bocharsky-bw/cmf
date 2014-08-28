<?php

namespace BW\ModuleBundle\Service;

use BW\ModuleBundle\Entity\Widget;

/**
 * Interface WidgetServiceInterface
 * @package BW\ModuleBundle\Service
 */
interface WidgetServiceInterface
{
    /**
     * Render the widget
     *
     * @param Widget $widget
     * @return string
     */
    public function render(Widget $widget);
}
