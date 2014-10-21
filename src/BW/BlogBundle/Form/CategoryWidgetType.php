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

        $builder
            ->add('mode', 'choice', [
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Отображать категории ',
                'choices' => [
                    false => 'Только перечисленные ',
                    true => 'Все, кроме перечисленных '
                ],
            ])
            ->add('categories', 'entity', [
                'class' => 'BW\BlogBundle\Entity\Category',
                'property' => 'heading',
                'required' => false,
                'label' => 'Список категорий ',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }
}
