<?php

namespace BW\ModuleBundle\Entity;

use BW\MenuBundle\Entity\MenuWidget;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Widget
 * @package BW\ModuleBundle\Entity
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
    private $shortDescription = '';

    /**
     * @var boolean $published
     */
    private $published = true;

    /**
     * @var integer $order
     */
    private $order = 0;

    /**
     * @var boolean $visibility
     */
    private $visibility = true;

    /**
     * @var \BW\ModuleBundle\Entity\Type
     */
    private $type;

    /**
     * @var \BW\ModuleBundle\Entity\Position
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $widgetRoutes;

    /**
     * @var \BW\ModuleBundle\Entity\HtmlWidget
     */
    private $htmlWidget;

    /**
     * @var \BW\MenuBundle\Entity\MenuWidget
     */
    private $menuWidget;

    /**
     * @var \BW\ModuleBundle\Entity\FeedbackFormWidget
     */
    private $feedbackFormWidget;


    public function __construct()
    {
        $this->widgetRoutes = new ArrayCollection();
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
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Widget
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = isset($shortDescription) ? $shortDescription : '';

        return $this;
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

    /**
     * Set published
     *
     * @param boolean $published
     * @return Widget
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Widget
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set visibility
     *
     * @param boolean $visibility
     * @return Widget
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return boolean
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set type
     *
     * @param \BW\ModuleBundle\Entity\Type $type
     * @return Widget
     */
    public function setType(Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \BW\ModuleBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set position
     *
     * @param \BW\ModuleBundle\Entity\Position $position
     * @return Widget
     */
    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \BW\ModuleBundle\Entity\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add widgetRoutes
     *
     * @param \BW\ModuleBundle\Entity\WidgetRoute $widgetRoutes
     * @return Widget
     */
    public function addWidgetRoute(WidgetRoute $widgetRoutes)
    {
        $this->widgetRoutes[] = $widgetRoutes;

        return $this;
    }

    /**
     * Remove widgetRoutes
     *
     * @param \BW\ModuleBundle\Entity\WidgetRoute $widgetRoutes
     */
    public function removeWidgetRoute(WidgetRoute $widgetRoutes)
    {
        $this->widgetRoutes->removeElement($widgetRoutes);
    }

    /**
     * Get widgetRoutes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWidgetRoutes()
    {
        return $this->widgetRoutes;
    }

    /**
     * Set htmlWidget
     *
     * @param \BW\ModuleBundle\Entity\HtmlWidget $htmlWidget
     * @return Widget
     */
    public function setHtmlWidget(HtmlWidget $htmlWidget = null)
    {
        $this->htmlWidget = $htmlWidget;

        return $this;
    }

    /**
     * Get htmlWidget
     *
     * @return \BW\ModuleBundle\Entity\HtmlWidget
     */
    public function getHtmlWidget()
    {
        return $this->htmlWidget;
    }

    /**
     * Set menuWidget
     *
     * @param \BW\MenuBundle\Entity\MenuWidget $menuWidget
     * @return Widget
     */
    public function setMenuWidget(MenuWidget $menuWidget = null)
    {
        $this->menuWidget = $menuWidget;

        return $this;
    }

    /**
     * Get menuWidget
     *
     * @return \BW\MenuBundle\Entity\MenuWidget 
     */
    public function getMenuWidget()
    {
        return $this->menuWidget;
    }

    /**
     * Set feedbackFormWidget
     *
     * @param \BW\ModuleBundle\Entity\FeedbackFormWidget $feedbackFormWidget
     * @return Widget
     */
    public function setFeedbackFormWidget(FeedbackFormWidget $feedbackFormWidget = null)
    {
        $this->feedbackFormWidget = $feedbackFormWidget;

        return $this;
    }

    /**
     * Get feedbackFormWidget
     *
     * @return \BW\ModuleBundle\Entity\FeedbackFormWidget 
     */
    public function getFeedbackFormWidget()
    {
        return $this->feedbackFormWidget;
    }
}
