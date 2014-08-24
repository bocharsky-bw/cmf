<?php

namespace BW\ModuleBundle\Controller;

use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Form\WidgetType;

/**
 * Class WidgetController
 * @package BW\ModuleBundle\Controller
 */
class WidgetController extends Controller
{

    /**
     * Lists all Widget entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BWModuleBundle:Widget')->findBy(array(), array(
            'position' => 'ASC',
            'order' => 'ASC',
        ));

        return $this->render('BWModuleBundle:Widget:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Widget entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Widget();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('widget'));
            }

            return $this->redirect($this->generateUrl('widget_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWModuleBundle:Widget:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Widget entity.
     *
     * @param Widget $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Widget $entity)
    {
        $form = $this->createForm(new WidgetType(), $entity, array(
            'action' => $this->generateUrl('widget_create'),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager(),
            'entity' => $entity,
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Widget entity.
     */
    public function newAction(Request $request)
    {
        $request->getSession()->set('AllowCKFinder', true); // Allow to use CKFinder

        $entity = new Widget();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWModuleBundle:Widget:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Widget entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWModuleBundle:Widget:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Widget entity.
     */
    public function editAction(Request $request, $id)
    {
        $request->getSession()->set('AllowCKFinder', true); // Allow to use CKFinder
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWModuleBundle:Widget:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Widget entity.
    *
    * @param Widget $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Widget $entity)
    {
        $form = $this->createForm(new WidgetType(), $entity, array(
            'action' => $this->generateUrl('widget_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'em' => $this->getDoctrine()->getManager(),
            'entity' => $entity,
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Widget entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($entity->getId());
                return $this->redirect($this->generateUrl('widget'));
            }
            /* Route to Widget binding */
            if ($widgetRouteId = $request->request->getInt('deleteWidgetRoute')) {
                $widgetRoute = $em->getRepository('BWModuleBundle:WidgetRoute')->find($widgetRouteId);
                $em->remove($widgetRoute);
            }

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('widget'));
            }

            return $this->redirect($this->generateUrl('widget_edit', array('id' => $id)));
        }

        return $this->render('BWModuleBundle:Widget:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Widget entity.
     */
    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a Widget entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('widget'));
    }

    /**
     * Creates a form to delete a Widget entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('widget_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
