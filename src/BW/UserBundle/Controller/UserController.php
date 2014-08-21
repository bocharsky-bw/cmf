<?php

namespace BW\UserBundle\Controller;

use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BW\UserBundle\Entity\User;
use BW\UserBundle\Form\UserType;

/**
 * Class UserController
 * @package BW\UserBundle\Controller
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->getRepository('BWUserBundle:User')->createQueryBuilder('u');
        $qb
            ->addSelect('p')
            ->addSelect('r')
            ->leftJoin('u.profile', 'p')
            ->leftJoin('u.roles', 'r')
        ;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $request->query->getInt('count', 10)
        );

        return $this->render('BWUserBundle:User:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new User entity.
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            $em->flush();

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('user'));
            }

            return $this->redirect($this->generateUrl('user_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWUserBundle:User')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWUserBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWUserBundle:User')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWUserBundle:User:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing User entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWUserBundle:User')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($id);
                return $this->redirect($this->generateUrl('user'));
            }

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('user'));
            }

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render('BWUserBundle:User:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWUserBundle:User')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a User entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

}
