<?php

namespace BW\ModuleBundle\Form;

use BW\ModuleBundle\Entity\CustomWidget;
use BW\ModuleBundle\Entity\Widget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomWidgetType extends AbstractType
{
    private $widget;


    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Полное описание ',
                'attr' => array(
                    'class' => 'form-control ckeditor',
                ),
            ))
        ;
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
                'data_class' => 'BW\ModuleBundle\Entity\CustomWidget',
                'empty_data' => function () {
                    $customWidget = new CustomWidget();
                    $customWidget->setWidget($this->widget);

                    return $customWidget;
                },
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_custom_widget';
    }
}
