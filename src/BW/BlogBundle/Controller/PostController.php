<?php

namespace BW\BlogBundle\Controller;

use BW\RouterBundle\Entity\Route;
use BW\SkeletonBundle\Utility\FormUtility;
use BW\BlogBundle\Entity\Post;
use BW\BlogBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PostController
 * @package BW\BlogBundle\Controller
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->getRepository('BWBlogBundle:Post')->createQueryBuilder('p');
        $qb
            ->addSelect('c')
            ->addSelect('r')
            ->leftJoin('p.category', 'c')
            ->innerJoin('p.route', 'r')
        ;

        $quickSearchForm = $this->get('bw_default.service.quick_search')->createForm();
        $quickSearchForm->handleRequest($request);
        if ($quickSearchForm->isSubmitted()) {
            $data = $quickSearchForm->getData();

            // Quick jump to the entity by ID
            if (preg_match('/^\d+$/', $data['query'])) {
                $qb->where($qb->expr()->eq('p.id', (int)$data['query']));
                $entity = $qb->getQuery()->getOneOrNullResult();
                if ($entity) {
                    return $this->redirect($this->generateUrl('post_edit', [
                        'id' => $entity->getId(),
                    ]));
                }
            }

            $qb
                ->where('p.heading LIKE :query')
                ->setParameter('query', "%{$data['query']}%")
            ;
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $request->query->getInt('count', 10)
        );

        return $this->render('BWBlogBundle:Post:index.html.twig', array(
            'pagination' => $pagination,
            'quickSearchForm' => $quickSearchForm->createView(),
        ));
    }

    /**
     * Creates a new Post entity.
     */
    public function createAction(Request $request)
    {
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();

        $entity = new Post();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $flashBag->add('success', 'Статья успешно создана.');

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('post'));
            } elseif ($form->get('createAndShow')->isClicked()) {
                return $this->redirect($request->getUriForPath($entity->getRoute()->getPath()));
            }

            return $this->redirect($this->generateUrl('post_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWBlogBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);
        FormUtility::addCreateAndShowButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
     */
    public function newAction(Request $request)
    {
        $request->getSession()->set('AllowCKFinder', true); // Allow to use CKFinder

        $entity = new Post();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWBlogBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWBlogBundle:Post')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWBlogBundle:Post:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     */
    public function editAction(Request $request, $id)
    {
        $request->getSession()->set('AllowCKFinder', true); // Allow to use CKFinder
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWBlogBundle:Post')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('BWBlogBundle:Post:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Post entity.
    *
    * @param Post $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addUpdateAndShowButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Post entity.
     */
    public function updateAction(Request $request, $id)
    {
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();
        $em = $this->getDoctrine()->getManager();

        /** @var \BW\BlogBundle\Entity\Post $entity */
        $entity = $em->getRepository('BWBlogBundle:Post')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($request, $entity->getId());
                return $this->redirect($this->generateUrl('post'));
            }

            $em->flush();
            $flashBag->add('success', 'Статья успешно обновлена.');

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('post'));
            } elseif ($editForm->get('updateAndShow')->isClicked()) {
                return $this->redirect($request->getUriForPath($entity->getRoute()->getPath()));
            }

            return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
        }

        return $this->render('BWBlogBundle:Post:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     */
    private function delete(Request $request, $id)
    {
        /** @var FlashBag $flashBag */
        $flashBag = $request->getSession()->getFlashBag();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWBlogBundle:Post')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $em->remove($entity);
        $em->flush();
        $flashBag->add('danger', 'Статья успешно удалена.');
    }

    /**
     * Deletes a Post entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($request, $id);
        }

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
