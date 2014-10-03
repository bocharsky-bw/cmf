<?php

namespace BW\DefaultBundle\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

/**
 * Class QuickSearchService
 * @package BW\DefaultBundle\Service
 */
class QuickSearchService
{
    /**
     * @var FormFactory
     */
    private $formFactory;


    /**
     * The constructor
     *
     * @param FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }


    /**
     * @param null|mixed $data
     * @return Form
     */
    public function createForm($data = null)
    {
        return $this->formFactory->createNamedBuilder('', 'form', null, [
            'csrf_protection' => false,
            'attr' => [
                'class' => 'navbar-form navbar-left',
            ],
        ])
            ->setMethod('GET')
            ->add('query', 'text', [
                'required' => false,
                'label' => ' ',
                'label_attr' => [
                    'class' => 'input-group-addon fas fa-info-circle',
                    'title' => sprintf(''
                        . 'Введите полное название записи или его часть для поиска соответствий. '
                        . 'Используйте ID для быстрого перехода в режим редактирования записи.'
                    ),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Что ищем?..',
                    'title' => 'вфцвафц',
                ],
            ])
            ->add('search', 'submit', [
                'label' => 'Найти',
                'attr' => [
                    'class' => 'btn btn-default',
                ],
            ])
            ->getForm()
        ;
    }
}