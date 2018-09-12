<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
		return $this->render('OCCoreBundle:Core:index.html.twig');
    }

    public function contactAction()
    {
		$this->addFlash('notice', 'La page de contact n\'est pas encore disponible. Merci de revenir plus tard.');
		return $this->redirectToRoute('oc_core_homepage');
    }
}
