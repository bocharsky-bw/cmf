<?php

namespace BW\BlogBundle\Controller;

use BW\RouterBundle\Entity\Route;
use BW\SkeletonBundle\Utility\FormUtility;
use BW\BlogBundle\Entity\Category;
use BW\BlogBundle\Form\CategoryType;
use Symfony\Component\Form\Util\FormUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package BW\BlogBundle\Controller
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->getRepository('BWBlogBundle:Category')->createQueryBuilder('c');
        $qb
            ->addSelect('r')
            ->innerJoin('c.route', 'r')
            ->orderBy('c.left', 'ASC')
        ;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $request->query->getInt('count', 10)
        );

        return $this->render('BWBlogBundle:Category:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Category entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            // Regenerate nested set
            $this->get('bw_default.service.nested_set')->regenerate('BWBlogBundle:Category');

            $em->flush();

            /* Route */
            $route = new Route();
            $route->handleEntity($entity);
            $em->persist($route);
            $em->flush();
            /* /Route */

            if ($form->get('createAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('category'));
            } elseif ($form->get('createAndShow')->isClicked()) {
                return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
            }

            return $this->redirect($this->generateUrl('category_edit', array('id' => $entity->getId())));
        }

        return $this->render('BWBlogBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

        FormUtility::addCreateButton($form);
        FormUtility::addCreateAndCloseButton($form);
        FormUtility::addCreateAndShowButton($form);

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);

        return $this->render('BWBlogBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Category entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWBlogBundle:Category')->find($id);
        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->getRepository('BWBlogBundle:Post')->createQueryBuilder('p');
        $qb
            ->addSelect('c')
            ->addSelect('r')
            ->innerJoin('p.category', 'c')
            ->innerJoin('p.route', 'r')
            ->where($qb->expr()->andX(
                $qb->expr()->gte('c.left', ':left'),
                $qb->expr()->lt('c.left', ':right')
            ))
            ->setParameter('left', $entity->getLeft())
            ->setParameter('right', $entity->getRight())
        ;
        $posts = $qb->getQuery()->getResult();

        return $this->render('BWBlogBundle:Category:show.html.twig', array(
            'entity' => $entity,
            'posts' => $posts,
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWBlogBundle:Category')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BWBlogBundle:Category:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        FormUtility::addUpdateButton($form);
        FormUtility::addUpdateAndCloseButton($form);
        FormUtility::addUpdateAndShowButton($form);
        FormUtility::addDeleteButton($form);

        return $form;
    }

    /**
     * Edits an existing Category entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BWBlogBundle:Category')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('delete')->isClicked()) {
                $this->delete($entity->getId());
                return $this->redirect($this->generateUrl('category'));
            }
            $em->flush();

            // Route
            $entity->getRoute()->handleEntity($entity);

            // Regenerate nested set
            $this->get('bw_default.service.nested_set')->regenerate('BWBlogBundle:Category');

            $em->flush();

            if ($editForm->get('updateAndClose')->isClicked()) {
                return $this->redirect($this->generateUrl('category'));
            } elseif ($editForm->get('updateAndShow')->isClicked()) {
                return $this->redirect($this->generateUrl('category_show', array('id' => $id)));
            }

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return $this->render('BWBlogBundle:Category:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Category entity.
     */
    private function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BWBlogBundle:Category')->find($id);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Deletes a Category entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->delete($id);
        }

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
