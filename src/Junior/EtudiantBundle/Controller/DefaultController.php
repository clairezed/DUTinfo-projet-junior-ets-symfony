<?php

namespace Junior\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JuniorEtudiantBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function dashboardAction()
    {
        return $this->render('JuniorEtudiantBundle:Etudiant:dashboardEtudiant.html.twig');
    }
}




