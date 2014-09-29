<?php

namespace BW\ModuleBundle\Form;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Form\DataTransformer\UrlToWidgetRoutesTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws ClassNotFoundException
     * @throws \Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // this assumes that the entity manager was passed in as an option
        /** @var EntityManager $em */
        $em = $options['em'];
        /** @var Widget $entity */
        $entity = $options['entity'];

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
                'required' => false,
                'label' => 'Заголовок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('shortDescription', 'textarea', array(
                'required' => false,
                'label' => 'Краткое описание ',
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
            ->add('class', 'text', array(
                'required' => false,
                'label' => 'HTML атрибут "class" ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('visibility', 'choice', array(
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Видимость ',
                'choices' => array(
                    false => 'Только на перечисленных роутах ',
                    true => 'На всех роутах, кроме перечисленных '
                ),
            ))
        ;

        // Widget
        if (null === $entity->getType()) {
            throw new \InvalidArgumentException(sprintf(''
                . 'The "BW\ModuleBundle\Entity\Widget" entity must be related with "BW\ModuleBundle\Entity\Type" entity. '
                . 'Choose type of widget you want to create/update.'
            ));
        }
        $property = $entity->getType()->getInversedProperty();
        if ( ! property_exists('BW\ModuleBundle\Entity\Widget', $property)) {
            throw new NoSuchPropertyException(sprintf(''
                . 'The property "%s" in "BW\ModuleBundle\Entity\Widget" entity not exists. '
                . 'Maybe you forgot to add it for mapping or used wrong name in database?',
                $property
            ));
        }
        $formTypeClass = $entity->getType()->getFormTypeClass();
        if ( ! class_exists($formTypeClass)) {
            throw new ClassNotFoundException(sprintf(''
                . 'The "%s" form type not found. '
                . 'Maybe you forgot to create it or used wrong name in database?',
                $formTypeClass
            ), new \ErrorException());
        }
        $formType = new $formTypeClass($entity);
        if ( ! ($formType instanceof AbstractWidgetType)) {
            throw new \Exception(sprintf(
                'The "%s" must extends "BW\ModuleBundle\Form\AbstractWidgetType".', $formTypeClass
            ));
        }
        $builder->add($property, $formType);

        // add a normal text field, but add your transformer to it
        $transformer = new UrlToWidgetRoutesTransformer($em, $entity);
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
