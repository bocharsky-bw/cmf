<?php

namespace BW\MenuBundle\Form;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label' => 'Название ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('url', 'url', array(
                'required' => false,
                'label' => 'Адрес URL ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('title', 'text', array(
                'required' => false,
                'label' => 'Всплывающая подсказка ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('class', 'text', array(
                'required' => false,
                'label' => 'Класс CSS ',
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
            ->add('menu', 'entity', array(
                'class' => 'BW\MenuBundle\Entity\Menu',
                'property' => 'name',
                'required' => true,
                'label' => 'Меню ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('parent', 'entity', array(
                'class' => 'BW\MenuBundle\Entity\Item',
                //'property' => 'heading',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    /** @var \BW\MenuBundle\Entity\Item $entity */
                    $entity = $options['data'];

                    return $er->createQueryBuilder('c')
                        ->where('c.id != :id')
                        ->andWhere('c.left < :left OR c.left > :right')
                        ->orderBy('c.left', 'ASC')
                        ->setParameter('id', (int)$entity->getId(), Type::INTEGER)
                        ->setParameter('left', (int)$entity->getLeft(), Type::INTEGER)
                        ->setParameter('right', (int)$entity->getRight(), Type::INTEGER)
                        ;
                },
                'required' => false,
                'label' => 'Родительский пункт меню ',
                'empty_value' => '< Корневой пункт меню >',
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
            'data_class' => 'BW\MenuBundle\Entity\Item'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_item';
    }
}
