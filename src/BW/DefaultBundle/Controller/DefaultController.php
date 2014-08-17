<?php

namespace BW\DefaultBundle\Controller;

use BW\UploadBundle\File\SourceImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function adminAction()
    {
        return $this->render('BWDefaultBundle:Default:admin.html.twig');
    }

    public function indexAction()
    {
        return $this->render('BWDefaultBundle:Default:index.html.twig');
    }
}
