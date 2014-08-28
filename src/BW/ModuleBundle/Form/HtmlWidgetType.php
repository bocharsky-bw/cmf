<?php

namespace BW\ModuleBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HtmlWidgetType
 * @package BW\ModuleBundle\Form
 */
class HtmlWidgetType extends AbstractWidgetType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Полное описание ',
                'attr' => array(
                    'class' => 'form-control ckeditor',
                ),
            ))
        ;
    }
}
