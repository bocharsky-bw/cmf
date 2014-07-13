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
                'required' => FALSE,
            ))
            ->add('heading', 'text')
            ->add('shortDescription', 'textarea', array(
                'required' => FALSE,
            ))
            ->add('description', 'textarea', array(
                'required' => FALSE,
            ))
            // Entities
            // Lang
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
                'required' => FALSE,
                'empty_value' => '< Корневая категория >',
            ))
            ->add('order', 'number', array(
                'required' => false,
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
