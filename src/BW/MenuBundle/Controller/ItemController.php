<?php

namespace BW\MenuBundle\Controller;

use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BW\MenuBundle\Entity\Item;
use BW\MenuBundle\Form\ItemType;

/**
 * Class ItemController
 * @package BW\MenuBundle\Controller
 */
class ItemController extends Controller
{

    /**
     * Lists all Item entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BWMenuBundle:Item')->findAll();

        return $this->render('BWMenuBundle:Item:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Item entity.
     */
    public function createAction(Request $request, $menu_id)
    {
        $entity = new Item();
        $entity->setMenu(
            $this->getDoctrine()->getRepository('BWMenuBundle:Menu')->find($menu_id)
        );
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('menu_edit', array(
                    'id' => $entity->getMenu()->getId(),
                )));
            }

            return $this->redirect($this->generateUrl('item_edit', array(
                'menu_id' => $entity->getMenu()->getId(),
                'id' => $entity->getId(),
            )));
        }

        return $this->render('BWMenuBundle:Item:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Item entity.
     *
     * @param Item $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(), $entity, array(
            'action' => $this->generateUrl('item_create', array(
                'menu_id' => $entity->getMenu()->getId(),
            )),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Item entity.
     */
    public function newAction($menu_id)
    {
        $entity = new Item();
        $entity->setMenu(
            $this->getDoctrine()->getRepository('BWMenuBundle:Menu')->find($menu_id)
        );
        $form = $this->createCreateForm($entity);

        return $this->render('BWMenuBundle:Item:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Item entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Item')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        return $this->render('BWMenuBundle:Item:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Item entity.
     */
    public function editAction($menu_id, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Item')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('BWMenuBundle:Item:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Item entity.
     *
     * @param Item $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(), $entity, array(
            'action' => $this->generateUrl('item_update', array(
                'menu_id' => $entity->getMenu()->getId(),
                'id' => $entity->getId(),
            )),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Item entity.
     */
    public function updateAction(Request $request, $menu_id, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWMenuBundle:Item')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($id);
                return $this->redirect($this->generateUrl('menu_edit', array(
                    'id' => $entity->getMenu()->getId(),
                )));
            }

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('menu_edit', array(
                    'id' => $entity->getMenu()->getId(),
                )));
            }

            return $this->redirect($this->generateUrl('item_edit', array(
                'menu_id' => $entity->getMenu()->getId(),
                'id' => $id,
            )));
        }

        return $this->render('BWMenuBundle:Item:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Item entity.
     */
    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWMenuBundle:Item')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a Item entity.
     */
    public function deleteAction(Request $request, $menu_id, $id)
    {
        $form = $this->createDeleteForm($menu_id, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('item'));
    }

    /**
     * Creates a form to delete a Item entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($menu_id, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array(
                'menu_id' => $menu_id,
                'id' => $id,
            )))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
