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
            ))
            ->add('home', 'checkbox', array(
                'required' => FALSE,
            ))
            ->add('heading', 'text')
            ->add('shortDescription', 'textarea', array(
                'required' => FALSE,
            ))
            ->add('description', 'textarea', array(
                'required' => FALSE,
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
            ))
            // Meta tags
            ->add('slug', 'text', array(
                'required' => FALSE,
            ))
            ->add('title', 'text', array(
                'required' => FALSE,
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => FALSE,
            ))
            // Buttons
            ->add('save', 'submit')
            ->add('saveAndClose', 'submit')
            ->add('delete', 'submit')
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
