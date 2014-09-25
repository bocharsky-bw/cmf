<?php

namespace BW\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DatabaseController
 * @package BW\DefaultBundle\Controller
 */
class DatabaseController extends Controller
{
    private function getDumpPath()
    {
        $kernel = $this->get('kernel');

        return $kernel->getCacheDir() . '/../dump';
    }

    public function listAction()
    {
        $fs = $this->get('filesystem');

        if ($fs->exists($this->getDumpPath())) {
            $finder = new Finder();
            $files = $finder->files()->in($this->getDumpPath())->sort(function (SplFileInfo $a, SplFileInfo $b) {
                return strcmp($b->getMTime(), $a->getMTime()); // sort by modifiedTime DESC
            });
        } else {
            $files = array();
        }

        $form = $this->createDumpForm();

        return $this->render('BWDefaultBundle:Database:list.html.twig', [
            'files' => $files,
            'form' => $form->createView(),
        ]);
    }

    public function dumpAction(Request $request)
    {
        $session = $request->getSession();
        $container = $this->get('service_container');
        $fs = $this->get('filesystem');

        // Check right driver
        if (0 !== strcasecmp('pdo_mysql', $container->getParameter('database_driver'))) {
            throw new \InvalidArgumentException('The database backup work only with "pdo_mysql" driver.');
        }

        // Get absolute path to program
        $commandPath = exec('which mysqldump');
        if (! $commandPath) {
            throw new \RuntimeException('The database backup program "mysqldump" not found.');
        }

        // Make database dump dir if not exists
        if (! $fs->exists($this->getDumpPath())) {
            $fs->mkdir($this->getDumpPath());
        }

        // Touched new file
        $filename = date('Y-m-d_H:i:s') . '_' . uniqid() . '.sql';
        $fs->touch($this->getDumpPath() . DIRECTORY_SEPARATOR . $filename);

        // Execute dump command
        $result = exec(sprintf(
            '%s %s -u %s -p%s > "%s"'
            , $commandPath
            , $container->getParameter('database_name')
            , $container->getParameter('database_user')
            , $container->getParameter('database_password')
            , $this->getDumpPath() . DIRECTORY_SEPARATOR . $filename
        ), $output, $return_var);

        if (0 === $return_var) {
            $session->getFlashBag()->add('success', 'Файл дампа БД успешно создан.');
        } else {
            $session->getFlashBug()->add('danger', 'При создании файла дампа БД произошла ошибка.');
            if ($fs->exists($this->getDumpPath() . DIRECTORY_SEPARATOR . $filename)) {
                $fs->remove($this->getDumpPath() . DIRECTORY_SEPARATOR . $filename);
            }
        }

        return $this->redirect($this->generateUrl('database'));
    }

    public function createDumpForm()
    {
        return $this->createFormBuilder()
            ->setMethod('POST')
            ->setAction($this->generateUrl('database_dump'))
            ->add('start', 'submit', [
                'label' => ' Сделать дамп БД',
                'attr' => [
                    'class' => 'btn btn-success fas fa-play',
                ],
            ])
            ->getForm()
        ;
    }

    public function deleteAction($filename)
    {
        $form = $this->createDeleteForm($filename);

        return $this->render('BWDefaultBundle:Database:delete.html.twig', array(
            'filename' => $filename,
            'form' => $form->createView(),
        ));
    }

    public function deleteConfirmAction(Request $request, $filename)
    {
        $session = $request->getSession();

        $form = $this->createDeleteForm($filename);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $fs = $this->get('filesystem');
            if ($fs->exists($this->getDumpPath() . DIRECTORY_SEPARATOR . $filename)) {
                $fs->remove($this->getDumpPath() . DIRECTORY_SEPARATOR . $filename);
                $session->getFlashBag()->add('warning', 'Файл дампа БД успешно удален.');
            } else {
                $session->getFlashBag()->add('danger', 'При удалении файла дампа БД произошла ошибка.');
            }
        }

        return $this->redirect($this->generateUrl('database'));
    }

    private function createDeleteForm($filename)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('database_dump_delete_confirm', array('filename' => $filename)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', [
                'label' => ' Удалить',
                'attr' => [
                    'class' => 'btn btn-danger fas fa-times',
//                    'onclick' => "return confirm('Удалить вакансию?');",
                ],
            ])
            ->getForm()
        ;
    }

    public function downloadAction()
    {

    }
}