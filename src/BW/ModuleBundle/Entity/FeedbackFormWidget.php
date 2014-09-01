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
    private $emailTo;

    /**
     * @var string
     */
    private $messageSubject;

    /**
     * @var string
     */
    private $messageBody;

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
     * Set emailTo
     *
     * @param string $emailTo
     * @return FeedbackFormWidget
     */
    public function setEmailTo($emailTo)
    {
        $this->emailTo = $emailTo;

        return $this;
    }

    /**
     * Get emailTo
     *
     * @return string
     */
    public function getEmailTo()
    {
        return $this->emailTo;
    }

    /**
     * Set messageSubject
     *
     * @param string $messageSubject
     * @return FeedbackFormWidget
     */
    public function setMessageSubject($messageSubject)
    {
        $this->messageSubject = $messageSubject;

        return $this;
    }

    /**
     * Get messageSubject
     *
     * @return string
     */
    public function getMessageSubject()
    {
        return $this->messageSubject;
    }

    /**
     * Set messageBody
     *
     * @param string $messageBody
     * @return FeedbackFormWidget
     */
    public function setMessageBody($messageBody)
    {
        $this->messageBody = $messageBody;

        return $this;
    }

    /**
     * Get messageBody
     *
     * @return string
     */
    public function getMessageBody()
    {
        return $this->messageBody;
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
