<?php

namespace BW\MenuBundle\Controller;

use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BW\MenuBundle\Entity\Menu;
use BW\MenuBundle\Form\MenuType;

/**
 * Class MenuController
 * @package BW\MenuBundle\Controller
 */
class MenuController extends Controller
{

    /**
     * Lists all Menu entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BWMenuBundle:Menu')->findAll();

        return $this->render('BWMenuBundle:Menu:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Menu entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('menu'));
            }

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWMenuBundle:Menu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_create'),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     */
    public function newAction()
    {
        $entity = new Menu();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWMenuBundle:Menu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Menu entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Menu')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWMenuBundle:Menu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Menu')->find($id);
        $items = $em->getRepository('BWMenuBundle:Item')->findBy(array(
            'menu' => $entity,
        ), array(
            'left' => 'ASC',
        ));


        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWMenuBundle:Menu:edit.html.twig', array(
            'entity' => $entity,
            'items' => $items,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Menu entity.
     *
     * @param Menu $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Menu entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($id);
                return $this->redirect($this->generateUrl('menu'));
            }

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('menu'));
            }

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
        }

        return $this->render('BWMenuBundle:Menu:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Menu entity.
     */
    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWMenuBundle:Menu')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a Menu entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
