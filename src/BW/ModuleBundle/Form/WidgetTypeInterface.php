<?php

namespace BW\ModuleBundle\Form;
use BW\ModuleBundle\Entity\Widget;

/**
 * Interface WidgetTypeInterface
 * @package BW\ModuleBundle\Form
 */
interface WidgetTypeInterface
{

    /**
     * @param Widget $widget
     */
    public function __construct(Widget $widget);

    /**
     * @return \BW\ModuleBundle\Entity\Widget
     */
    public function getWidget();

}
