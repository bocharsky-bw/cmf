<?php

namespace BW\BlogBundle\Form;

use BW\ModuleBundle\Form\AbstractWidgetType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MenuWidgetType
 * @package BW\BlogBundle\Form
 */
class CategoryWidgetType extends AbstractWidgetType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

//        $builder
//            ->add('categories', 'entity', array(
//                'class' => 'BW\MenuBundle\Entity\Menu',
//                'property' => 'name',
//                'required' => true,
//                'label' => 'Меню ',
//                'attr' => array(
//                    'class' => 'form-control',
//                ),
//            ))
//        ;
    }
}
