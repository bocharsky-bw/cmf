<?php

namespace BW\ModuleBundle\Controller;

use BW\ModuleBundle\Entity\FeedbackFormWidget;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FeedbackFormController
 * @package BW\ModuleBundle\Controller
 */
class FeedbackFormController extends Controller
{
    public function sendAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var FeedbackFormWidget $feedbackFormWidget */
        $feedbackFormWidget = $em->getRepository('BWModuleBundle:FeedbackFormWidget')->find($id);
        if ( ! $feedbackFormWidget) {
            throw $this->createNotFoundException('Unable to find FeedbackFormWidget entity.');
        }

        $message = \Swift_Message::newInstance()
            ->setSubject($feedbackFormWidget->getMessageSubject())
            ->setFrom($this->get('service_container')->getParameter('mailer_user'))
            ->setTo($feedbackFormWidget->getEmailTo())
            ->setBody($feedbackFormWidget->getMessageBody()) /** @TODO Need to replace with form placeholders */
            ->setContentType('text/html')
        ;
        $isSent = $this->get('mailer')->send($message); /** @TODO Need to use flash messages */

        $url = $feedbackFormWidget->getRedirectUrl()
            ? $feedbackFormWidget->getRedirectUrl()
            : '/' /** @TODO Need to get from form data */
        ;

        return $this->redirect($url);
    }
}
