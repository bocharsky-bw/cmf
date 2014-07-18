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
                'required' => false,
                'label' => 'Опубликовано ',
            ))
            ->add('category', 'entity', array(
                'class' => 'BWBlogBundle:Category',
                //'property' => 'heading',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.left', 'ASC')
                    ;
                },
                'required' => false,
                'label' => 'Категория ',
                'empty_value' => '< Без категории >',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('home', 'checkbox', array(
                'required' => false,
                'label' => 'Главная ',
            ))
            ->add('heading', 'text', array(
                'required' => true,
                'label' => 'Заголовок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('shortDescription', 'textarea', array(
                'required' => false,
                'label' => 'Короткое описание ',
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
            ->add('created', 'datetime', array(
                'required' => false,
                'label' => 'Дата создания',
            ))
            // SEO
            ->add('slug', 'text', array(
                'label' => 'Синоним URL ',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('title', 'text', array(
                'label' => 'Заголовок в браузере ',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('metaDescription', 'textarea', array(
                'label' => 'Описание страницы ',
                'required' => false,
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
        return 'bw_post';
    }
}
