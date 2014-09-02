<?php

namespace BW\ModuleBundle\Controller;

use BW\ModuleBundle\Entity\FeedbackFormWidget;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * Class FeedbackFormController
 * @package BW\ModuleBundle\Controller
 */
class FeedbackFormController extends Controller
{
    public function sendAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();

        /** @var FeedbackFormWidget $feedbackFormWidget */
        $feedbackFormWidget = $em->getRepository('BWModuleBundle:FeedbackFormWidget')->find($id);
        if ( ! $feedbackFormWidget) {
            throw $this->createNotFoundException('Unable to find FeedbackFormWidget entity.');
        }

        $form = $this->get('bw_module.service.feedback_form_widget')->createFeedbackForm($feedbackFormWidget);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject($feedbackFormWidget->getMessageSubject())
                ->setFrom($this->get('service_container')->getParameter('mailer_user'))
                ->setTo($feedbackFormWidget->getEmailTo())
                ->setBody(preg_replace_callback('/(?<placeholder>{(?<name>.+?)})/i', function($matches) use ($data) {
                    return isset($data[$matches['name']])
                        ? $data[$matches['name']]
                        : $matches['placeholder']
                    ;
                }, $feedbackFormWidget->getMessageBody()))
                ->setContentType('text/html');
            $isSent = $this->get('mailer')->send($message);
            if ($isSent) {
                $flashBag->add('success', 'Сообщение успешно отправлено.');
            } else {
                $flashBag->add('danger', 'Не удалось отправить сообщение.');
            }

            $url = $feedbackFormWidget->getRedirectUrl()
                ? $feedbackFormWidget->getRedirectUrl()
                : $data['_redirect_url']
            ;
        } else {
            $flashBag->add('danger', 'Не удалось отправить сообщение. Форма была некорректно заполнена.');
            $url = $data['_redirect_url']
                ? $data['_redirect_url']
                : $this->generateUrl('home', array(), true)
            ;
        }

        return $this->redirect($url);
    }
}
