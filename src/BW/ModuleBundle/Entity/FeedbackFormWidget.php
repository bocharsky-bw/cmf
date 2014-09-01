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
     * @var string
     */
    private $redirectUrl = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $subject = '';

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
     * Set redirectUrl
     *
     * @param string $redirectUrl
     * @return FeedbackFormWidget
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = isset($redirectUrl) ? $redirectUrl : '';

        return $this;
    }

    /**
     * Get redirectUrl
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return FeedbackFormWidget
     */
    public function setEmail($email)
    {
        $this->email = isset($email) ? $email : '';

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return FeedbackFormWidget
     */
    public function setSubject($subject)
    {
        $this->subject = isset($subject) ? $subject : '';

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
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
