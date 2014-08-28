<?php

namespace BW\MenuBundle\Form;

use BW\ModuleBundle\Form\AbstractWidgetType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MenuWidgetType
 * @package BW\MenuBundle\Form
 */
class MenuWidgetType extends AbstractWidgetType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('menu', 'entity', array(
                'class' => 'BW\MenuBundle\Entity\Menu',
                'property' => 'name',
                'required' => true,
                'label' => 'Меню ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }
}
