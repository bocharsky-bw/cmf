<?php

namespace BW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label' => 'Активный ',
            ))
            ->add('confirmed', 'checkbox', array(
                'required' => false,
                'label' => 'Подтвержденный ',
            ))
            ->add('username', 'text', array(
                'required' => true,
                'label' => 'Логин',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('password', 'text', array(
                'required' => true,
                'label' => 'Пароль',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'text', array(
                'required' => false,
                'label' => 'E-mail',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('created', 'datetime', array(
                'required' => false,
                'label' => 'Дата создания',
            ))
            ->add('facebookId', 'text', array(
                'required' => false,
                'label' => 'Facebook ID',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('googleId', 'text', array(
                'required' => false,
                'label' => 'Google ID ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('vkId', 'text', array(
                'required' => false,
                'label' => 'ВКонтакте ID',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('roles', 'entity', array(
                'class' => 'BW\UserBundle\Entity\Role',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Роли',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BW\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_user';
    }
}
