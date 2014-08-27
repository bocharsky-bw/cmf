<?php

namespace BW\ModuleBundle\Form;

use BW\ModuleBundle\Entity\Widget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractWidgetType
 * @package BW\ModuleBundle\Form
 */
class AbstractWidgetType extends AbstractType implements WidgetTypeInterface
{
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
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'BW\ModuleBundle\Entity\CustomWidget', // @TODO Maybe must passed via constructor?
                'empty_data' => function () {
                    $customWidget = new CustomWidget(); // @TODO Maybe must passed via constructor?
                    $customWidget->setWidget($this->getWidget());

                    return $customWidget;
                },
            ))
        ;
    }

    /**
     * @return string
     * @TODO Maybe make autogenerate?
     */
    public function getName()
    {
        return 'bw_custom_widget';
    }
}
