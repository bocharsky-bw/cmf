<?php

namespace BW\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryType
 * @package BW\BlogBundle\Form
 */
class CategoryType extends AbstractType
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
            ->add('parent', 'entity', array(
                'class' => 'BWBlogBundle:Category',
                //'property' => 'heading',
                'query_builder' => function(EntityRepository $er) use($options) {
                    /** @var \BW\BlogBundle\Entity\Category $category */
                    $category = $options['data'];

                    return $er->createQueryBuilder('c')
                            ->where('c.id != :id')
                            ->andWhere('c.left < :left OR c.left > :right')
                            ->orderBy('c.left', 'ASC')
                            ->setParameter('id', $category->getId(), \PDO::PARAM_INT)
                            ->setParameter('left', $category->getLeft(), \PDO::PARAM_INT)
                            ->setParameter('right', $category->getRight(), \PDO::PARAM_INT)
                        ;
                },
                'required' => false,
                'label' => 'Родительская категория ',
                'empty_value' => '< Корневая категория >',
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
            ->add('order', 'number', array(
                'required' => false,
                'label' => 'Порядок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            // SEO
            ->add('slug', 'text', array(
                'required' => false,
                'label' => 'Синоним URL ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('title', 'text', array(
                'required' => false,
                'label' => 'Заголовок в браузере ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => false,
                'label' => 'Описание страницы ',
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
            'data_class' => 'BW\BlogBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_category';
    }
}
