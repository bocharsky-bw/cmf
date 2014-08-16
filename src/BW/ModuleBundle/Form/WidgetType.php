<?php

namespace BW\ModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // this assumes that the entity manager was passed in as an option
        $entityManager = $options['em'];
        $entity = $options['entity'];
        $transformer = new UrlToWidgetRoutesTransformer($entityManager, $entity);

        $builder
            ->add('published', 'checkbox', array(
                'required' => false,
                'label' => 'Опубликовано ',
            ))
            ->add('position', 'entity', array(
                'class' => 'BW\ModuleBundle\Entity\Position',
                'property' => 'name',
                'required' => false,
                'label' => 'Позиция ',
                'empty_value' => '< Без позиции >',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('heading', 'text', array(
                'required' => true,
                'label' => 'Заголовок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Полное описание ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('order', 'number', array(
                'required' => false,
                'label' => 'Порядок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('visibility', 'choice', array(
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Видимость ',
                'choices' => array(
                    false => 'Только на перечисленных роутах ',
                    true => 'На всех роутах, кроме перечисленных '
                ),
            ))
        ;

        // add a normal text field, but add your transformer to it
        $builder->add(
            $builder->create('widgetRoutes', 'text', array(
                'required' => false,
                'label' => 'Привязка к роуту ',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'http://example.com/contacts',
                ),
            ))
            ->addModelTransformer($transformer)
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'BW\ModuleBundle\Entity\Widget'
            ))
            ->setRequired(array(
                'em',
            ))
            ->setAllowedTypes(array(
                'em' => 'Doctrine\Common\Persistence\ObjectManager',
            ))
            ->setRequired(array(
                'entity',
            ))
            ->setAllowedTypes(array(
                'entity' => 'BW\ModuleBundle\Entity\Widget',
            ));
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_widget';
    }
}
