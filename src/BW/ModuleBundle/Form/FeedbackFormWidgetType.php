<?php

namespace BW\ModuleBundle\Form;

use BW\ModuleBundle\Form\DataTransformer\ArrayToCollectionTransformer;
use Symfony\Component\Form\FormBuilderInterface;

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
        $transformer = new ArrayToCollectionTransformer();
        $builder
            ->add('redirectUrl', 'text', array(
                'required' => false,
                'label' => 'Перенаправлять на URL',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'text', array(
                'required' => false,
                'label' => 'E-mail',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('subject', 'text', array(
                'required' => false,
                'label' => 'Тема письма',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add(
                $builder->create('fields', 'collection', array(
                    'type' => new FieldType(),
                    'required' => false,
                    'label' => 'Поля формы ',
                    'allow_add' => true,
                    'allow_delete' => true,
                ))->addModelTransformer($transformer)
            )
        ;
    }
}
