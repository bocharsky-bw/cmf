<?php

namespace BW\BlogBundle\Form;

use BW\UploadBundle\Form\ImageType;
use Doctrine\DBAL\Types\Type;
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
                'query_builder' => function (EntityRepository $er) use ($options) {
                    /** @var \BW\BlogBundle\Entity\Category $category */
                    $category = $options['data'];

                    return $er->createQueryBuilder('c')
                        ->where('c.id != :id')
                        ->andWhere('c.root != :root OR (c.left < :left OR c.left > :right)')
                        ->orderBy('c.left', 'ASC')
                        ->setParameter('id', (int)$category->getId(), Type::INTEGER)
                        ->setParameter('root', (int)$category->getRoot(), Type::INTEGER)
                        ->setParameter('left', $category->getLeft(), Type::INTEGER)
                        ->setParameter('right', $category->getRight(), Type::INTEGER)
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
                'label' => 'Краткое описание ',
                'attr' => array(
                    'class' => 'form-control ckeditor',
                ),
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Полное описание ',
                'attr' => array(
                    'class' => 'form-control ckeditor',
                ),
            ))
            ->add('class', 'text', array(
                'required' => false,
                'label' => 'HTML атрибут "class" ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('created', 'datetime', array(
                'required' => false,
                'label' => 'Дата создания',
            ))
            ->add('order', 'number', array(
                'required' => false,
                'label' => 'Порядок ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('image', new ImageType('categories'), array(
                'required' => false,
                'label' => ' ',
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
