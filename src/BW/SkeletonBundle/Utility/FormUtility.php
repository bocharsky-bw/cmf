<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.07.14
 * Time: 23:17
 */

namespace BW\SkeletonBundle\Utility;

use Symfony\Component\Form\FormInterface;

/**
 * Class FormUtility
 * @package BW\SkeletonBundle\Utility
 */
class FormUtility {

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function addCreateButton(FormInterface $form)
    {
        return $form->add('create', 'submit', array(
            'label' => ' Создать',
            'attr' => array(
                'class' => 'btn btn-primary fas fa-save',
                'title' => 'Создать запись и остаться в режиме редактирования',
            ),
        ));
    }

    public static function addCreateAndCloseButton(FormInterface $form)
    {
        return $form->add('createAndClose', 'submit', array(
            'label' => ' Создать и закрыть',
            'attr' => array(
                'class' => 'btn btn-success fas fa-save',
                'title' => 'Создать запись и выйти из режима редактирования',
            ),
        ));
    }

    public static function addCreateAndShowButton(FormInterface $form)
    {
        return $form->add('createAndShow', 'submit', array(
            'label' => ' Создать и просмотреть',
            'attr' => array(
                'class' => 'btn btn-warning fas fa-eye',
                'title' => 'Создать запись и просмотреть ',
            ),
        ));
    }

    public static function addUpdateButton(FormInterface $form)
    {
        return $form->add('update', 'submit', array(
            'label' => ' Обновить',
            'attr' => array(
                'class' => 'btn btn-primary fas fa-save',
                'title' => 'Обновить запись и остаться в режиме редактирования',
            ),
        ));
    }

    public static function addUpdateAndCloseButton(FormInterface $form)
    {
        return $form->add('updateAndClose', 'submit', array(
            'label' => ' Обновить и закрыть',
            'attr' => array(
                'class' => 'btn btn-success fas fa-save',
                'title' => 'Обновить запись и выйти из режима редактирования',
            ),
        ));
    }

    public static function addUpdateAndShowButton(FormInterface $form)
    {
        return $form->add('updateAndShow', 'submit', array(
            'label' => ' Обновить и просмотреть',
            'attr' => array(
                'class' => 'btn btn-warning fas fa-eye',
                'title' => 'Обновить запись и просмотреть',
            ),
        ));
    }

    public static function addDeleteButton(FormInterface $form)
    {
        return $form->add('delete', 'submit', array(
            'label' => ' Удалить',
            'attr' => array(
                'class' => 'btn btn-danger fas fa-trash-o',
                'title' => 'Удалить запись из БД',
                'onclick' => "return confirm('Удалить запись из БД?')",
            )
        ));
    }
}
