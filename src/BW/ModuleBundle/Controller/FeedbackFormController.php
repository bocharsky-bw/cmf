<?php

namespace BW\ModuleBundle\Controller;

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

        $feedbackFormWidget = $em->getRepository('BWModuleBundle:FeedbackFormWidget')->find($id);
        if ( ! $feedbackFormWidget) {
            throw $this->createNotFoundException('Unable to find FeedbackFormWidget entity.');
        }

//        return $this->redirect('/');
    }
}
