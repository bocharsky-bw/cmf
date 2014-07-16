<?php

namespace BW\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class PostType
 * @package BW\BlogBundle\Form
 */
class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('published', 'checkbox', array(
                'required' => FALSE,
                'label' => 'Опубликовано ',
            ))
            ->add('home', 'checkbox', array(
                'required' => FALSE,
                'label' => 'Главная ',
            ))
            ->add('heading', 'text', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('shortDescription', 'textarea', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('description', 'textarea', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('created', 'datetime')
            // Entities
            // Category
            ->add('category', 'entity', array(
                'class' => 'BWBlogBundle:Category',
                //'property' => 'heading',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                            ->orderBy('c.left', 'ASC')
                        ;
                },
                'required' => FALSE,
                'empty_value' => '< Без категории >',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            // Meta tags
            ->add('slug', 'text', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('title', 'text', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            // Buttons
            ->add('save', 'submit', array(
                'label' => 'Сохранить',
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ))
            ->add('saveAndClose', 'submit', array(
                'label' => 'Сохранить и закрыть',
                'attr' => array(
                    'class' => 'btn btn-success',
                ),
            ))
            ->add('delete', 'submit', array(
                'label' => 'Удалить',
                'attr' => array(
                    'class' => 'btn btn-danger',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'BW\BlogBundle\Entity\Post',
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'post';
    }
}
