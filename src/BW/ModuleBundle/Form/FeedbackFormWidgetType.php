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
            ->add('emailTo', 'text', array(
                'required' => false,
                'label' => 'E-mail',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('messageSubject', 'text', array(
                'required' => false,
                'label' => 'Тема сообщения',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('messageBody', 'textarea', array(
                'required' => false,
                'label' => 'Текст сообщения',
                'attr' => array(
                    'class' => 'form-control ckeditor',
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
