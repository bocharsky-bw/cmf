<?php

namespace BW\ModuleBundle\Entity;

/**
 * Interface WidgetInterface
 * @package BW\ModuleBundle\Entity
 */
interface WidgetInterface
{
    /**
     * Set widget
     *
     * @param \BW\ModuleBundle\Entity\Widget $widget
     * @return CustomWidget
     */
    public function setWidget(Widget $widget = null);

    /**
     * Get widget
     *
     * @return \BW\ModuleBundle\Entity\Widget
     */
    public function getWidget();
}
