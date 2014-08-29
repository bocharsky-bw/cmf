<?php

namespace BW\ModuleBundle\Form;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Entity\WidgetInterface;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractWidgetType
 * @package BW\ModuleBundle\Form
 */
class AbstractWidgetType extends AbstractType implements WidgetTypeInterface
{
    /**
     * @var Widget
     */
    private $widget;


    /**
     * The constructor
     *
     * @param Widget $widget
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }


    /**
     * @return \BW\ModuleBundle\Entity\Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setData(array(
            'widget' => $this->widget,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     * @throws ClassNotFoundException
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $widget = $this->getWidget();

        if ( ! class_exists($widget->getType()->getEntityClass())) {
            throw new ClassNotFoundException(sprintf(''
                . 'The "%s" entity not found. '
                . 'Maybe you forgot to create it or used wrong name in database?',
                $widget->getType()->getEntityClass()
            ), new \ErrorException());
        }

        $resolver
            ->setDefaults(array(
                'data_class' => $widget->getType()->getEntityClass(),
                'empty_data' => function () use ($widget) {
                    $entityClass = $widget->getType()->getEntityClass();

                    $entity = new $entityClass();
                    if ( ! ($entity instanceof WidgetInterface)) {
                        throw new \Exception(sprintf(
                            'The "%s" must implements "BW\ModuleBundle\Entity\WidgetInterface" interface.', $entityClass
                        ));
                    }
                    $entity->setWidget($widget);

                    return $entity;
                },
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $name = $this->getWidget()->getType()->getFormTypeClass();
        $name = strtolower($name);
        $name = str_replace('\\', '_', $name);
        $name = str_replace('widgettype', '_widget', $name);
        $name = str_replace(array('bundle', 'form_'), '', $name);

        return $name;
    }
}
