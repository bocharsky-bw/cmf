<?php

namespace BW\ModuleBundle\Controller;

use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BW\ModuleBundle\Entity\Position;
use BW\ModuleBundle\Form\PositionType;

/**
 * Class PositionController
 * @package BW\ModuleBundle\Controller
 */
class PositionController extends Controller
{

    /**
     * Lists all Position entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BWModuleBundle:Position')->findBy(array(), array(
            'name' => 'ASC',
        ));

        return $this->render('BWModuleBundle:Position:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Position entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Position();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('position'));
            }

            return $this->redirect($this->generateUrl('position_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWModuleBundle:Position:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Position entity.
     *
     * @param Position $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Position $entity)
    {
        $form = $this->createForm(new PositionType(), $entity, array(
            'action' => $this->generateUrl('position_create'),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Position entity.
     */
    public function newAction()
    {
        $entity = new Position();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWModuleBundle:Position:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Position entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Position')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWModuleBundle:Position:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Position entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Position')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWModuleBundle:Position:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Position entity.
    *
    * @param Position $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Position $entity)
    {
        $form = $this->createForm(new PositionType(), $entity, array(
            'action' => $this->generateUrl('position_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Position entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Position')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($entity->getId());
                return $this->redirect($this->generateUrl('position'));
            }

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('position'));
            }

            return $this->redirect($this->generateUrl('position_edit', array('id' => $id)));
        }

        return $this->render('BWModuleBundle:Position:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Position entity.
     */
    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWModuleBundle:Position')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a Position entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('position'));
    }

    /**
     * Creates a form to delete a Position entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('position_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
