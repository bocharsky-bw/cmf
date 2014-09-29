<?php

namespace BW\ModuleBundle\Controller;

use BW\ModuleBundle\Entity\Type;
use BW\ModuleBundle\Entity\Widget;
use BW\ModuleBundle\Form\WidgetType;
use BW\SkeletonBundle\Utility\FormUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class WidgetController
 * @package BW\ModuleBundle\Controller
 */
class WidgetController extends Controller
{
    /**
     * Lists all Widget entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createSelectionTypeForm();
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->getRepository('BWModuleBundle:Widget')->createQueryBuilder('w');
        $qb
            ->addSelect('t')
            ->addSelect('p')
            ->innerJoin('w.type', 't')
            ->leftJoin('w.position', 'p')
            ->orderBy('p.name', 'ASC')
            ->addOrderBy('w.order', 'ASC')
        ;

        $quickSearchForm = $this->get('bw_default.service.quick_search')->createForm();
        $quickSearchForm->handleRequest($request);
        if ($quickSearchForm->isSubmitted()) {
            $data = $quickSearchForm->getData();

            // Quick jump to the entity by ID
            if (preg_match('/^\d+$/', $data['query'])) {
                $qb->where($qb->expr()->eq('w.id', (int)$data['query']));
                $entity = $qb->getQuery()->getOneOrNullResult();
                if ($entity) {
                    return $this->redirect($this->generateUrl('widget_edit', [
                        'id' => $entity->getId(),
                    ]));
                }
            }

            $qb
                ->where('w.heading LIKE :query')
                ->setParameter('query', "%{$data['query']}%")
            ;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $request->query->getInt('count', 10)
        );

        return $this->render('BWModuleBundle:Widget:index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
            'quickSearchForm' => $quickSearchForm->createView(),
        ));
    }

    public function createSelectionTypeForm()
    {
        $form = $this->get('form.factory')
            ->createNamedBuilder('', 'form', null, array(
                'csrf_protection' => false,
            ))
            ->setAction($this->generateUrl('widget_new'))
            ->setMethod('GET')
            ->add('type', 'entity', array(
                'class' => 'BW\ModuleBundle\Entity\Type',
                'property' => 'name',
                'required' => true,
                'label' => 'Тип ',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->getForm()
        ;

        return $form;
    }

    /**
     * Creates a new Widget entity.
     */
    public function createAction(Request $request)
    {
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();

        $entity = new Widget();
        $type = $this->getDoctrine()->getRepository('BWModuleBundle:Type')->find(
            $request->query->getInt('type')
        );
        $entity->setType($type);

        $form = $this->createCreateForm($request, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $flashBag->add('success', 'Виджет успешно создан.');

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
    private function createCreateForm(Request $request, Widget $entity)
    {
        $form = $this->createForm(new WidgetType(), $entity, array(
            'action' => $this->generateUrl('widget_create', array(
                'type' => $request->query->getInt('type'),
            )),
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
        $type = $this->getDoctrine()->getRepository('BWModuleBundle:Type')->find(
            $request->query->getInt('type')
        );
        $entity->setType($type);

        $form = $this->createCreateForm($request, $entity);

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
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();
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
                $this->delete($request, $entity->getId());
                return $this->redirect($this->generateUrl('widget'));
            }
            /* Route to Widget binding */
            if ($widgetRouteId = $request->request->getInt('deleteWidgetRoute')) {
                $widgetRoute = $em->getRepository('BWModuleBundle:WidgetRoute')->find($widgetRouteId);
                $em->remove($widgetRoute);
            }

            $em->flush();
            $flashBag->add('success', 'Виджет успешно обновлен.');

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
    private function delete(Request $request, $id)
    {
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $em->remove($entity);
        $em->flush();
        $flashBag->add('danger', 'Виджет успешно удален.');
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
