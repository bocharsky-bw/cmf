<?php

namespace BW\ModuleBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use BW\ModuleBundle\Form\DataTransformer\ArrayToJsonTransformer;

/**
 * Class FeedbackFormWidgetType
 * @package BW\ModuleBundle\Form
 */
class FeedbackFormWidgetType extends AbstractWidgetType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add a normal text field, but add your transformer to it
//        $transformer = new ArrayToJsonTransformer();
//        $builder->add(
//            $builder->create('fields', 'textarea', array(
//                'required' => true,
//                'label' => 'Поля формы ',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))->addModelTransformer($transformer)
//        );

        $transformer = new ArrayToJsonTransformer();
        $builder->add(
            $builder->create('fields', 'collection', array(
                'type' => 'textarea',
                'required' => true,
                'label' => 'Поля формы ',
            ))->addModelTransformer($transformer)
        );
    }
}
