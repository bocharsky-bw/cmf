<?php

namespace BW\ModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('child', 'text', array(
                'required' => true,
                'label' => 'Поле ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('type', 'text', array(
                'required' => true,
                'label' => 'Тип ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('options', 'textarea', array(
                'required' => false,
                'label' => 'Параметры ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BW\ModuleBundle\Entity\Field'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_field';
    }
}
