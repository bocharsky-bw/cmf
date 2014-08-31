<?php

namespace BW\ModuleBundle\Service;

use BW\ModuleBundle\Entity\Widget;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Form\FormFactory;

/**
 * Class FeedbackFormWidgetService
 * @package BW\ModuleBundle\Service
 */
class FeedbackFormWidgetService implements WidgetServiceInterface
{
    /**
     * @var FormFactory
     */
    private $formFactory;

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
    public function __construct(FormFactory $formFactory, \Twig_Environment $twig, Logger $logger)
    {
        $this->formFactory = $formFactory;
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
//        var_dump(json_encode(array(
//            'child' => 'name',
//            'type' => 'text',
//            'options' => array(
//                'label' => 'Имя',
//            ),
//        ))); die;
        $feedbackFormWidget = $widget->getFeedbackFormWidget();
        $fb = $this->formFactory->createBuilder();

        $fields = $feedbackFormWidget->getFields();
        foreach ($fields as $field) {
            $fb->add($field['child'], $field['type'], $field['options']);
        }

        $form = $fb->getForm();

        return $this->twig->render('BWModuleBundle:FeedbackFormWidget:show.html.twig', array(
            'feedbackFormWidget' => $feedbackFormWidget,
            'form' => $form->createView(),
        ));
    }
}
