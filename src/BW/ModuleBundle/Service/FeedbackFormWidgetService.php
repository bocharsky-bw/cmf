<?php

namespace BW\ModuleBundle\Service;

use BW\ModuleBundle\Entity\Widget;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class FeedbackFormWidgetService
 * @package BW\ModuleBundle\Service
 */
class FeedbackFormWidgetService implements WidgetServiceInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * The constructor
     *
     * @param FormFactory $formFactory
     * @param \Twig_Environment $twig
     * @param Logger $logger
     */
    public function __construct(RequestStack $requestStack, FormFactory $formFactory, Router $router, \Twig_Environment $twig, Logger $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->twig = $twig;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded service "%s".',
            __METHOD__
        ));
    }


    /**
     * Render the widget
     *
     * @param Widget $widget
     * @return string
     */
    public function render(Widget $widget)
    {
        $feedbackFormWidget = $widget->getFeedbackFormWidget();
        $fb = $this->formFactory->createBuilder();
        $fb
            ->setMethod('POST')
            ->setAction(
                $this->router->generate('bw_module_feedback_form_send', array(
                    'id' => $feedbackFormWidget->getId(),
                ))
            )
        ;

        $fields = $feedbackFormWidget->getFields();
        foreach ($fields as $field) {
            $fb->add($field['child'], $field['type'], $field['options']);
        }
        $fb->add('_redirect_url', 'hidden', array(
            'data' => $this->request->getSchemeAndHttpHost() . $this->request->getRequestUri(),
        ));

        $form = $fb->getForm();

        return $this->twig->render('BWModuleBundle:FeedbackFormWidget:show.html.twig', array(
            'feedbackFormWidget' => $feedbackFormWidget,
            'form' => $form->createView(),
        ));
    }
}
