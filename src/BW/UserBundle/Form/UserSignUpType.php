<?php

namespace BW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSignUpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'required' => true,
                'label' => 'Логин',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'text', array(
                'required' => true,
                'label' => 'E-mail',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('password', 'password', array(
                'required' => true,
                'label' => 'Пароль ',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('register', 'submit', array(
                'label' => 'Зарегистрироваться',
                'attr' => array(
                    'class' => 'btn btn-success',
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
            'data_class' => 'BW\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bw_user_sign_up';
    }
}
