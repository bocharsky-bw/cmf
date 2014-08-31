<?php

namespace BW\ModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FeedbackFormWidget
 * @package BW\DefaultBundle\Entity
 */
class FeedbackFormWidget implements WidgetInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BW\ModuleBundle\Entity\Widget
     */
    private $widget;

    /**
     * @var array
     */
    private $fields = array();


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
     * Set widget
     *
     * @param \BW\ModuleBundle\Entity\Widget $widget
     * @return HtmlWidget
     */
    public function setWidget(Widget $widget = null)
    {
        $this->widget = $widget;

        return $this;
    }

    /**
     * Get widget
     *
     * @return \BW\ModuleBundle\Entity\Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Set fields
     *
     * @param array $fields
     * @return FeedbackFormWidget
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get fields
     *
     * @return array 
     */
    public function getFields()
    {
        return $this->fields;
    }
}
