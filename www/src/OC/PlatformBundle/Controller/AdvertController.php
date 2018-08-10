<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
	public function indexAction($page)
	{
		// On ne sait pas combien de pages il y a
		// Mais on sait qu'une page doit être supérieure ou égale à 1
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
		}
		// Notre liste d'annonce en dur
		$listAdverts = array(
			array(
				'title'		=>	'Recherche développpeur Symfony',
				'id'		=>	1,
				'author'	=>	'Alexandre',
				'content'	=>	'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
				'date'		=>	new \Datetime()),
			array(
				'title'		=>	'Mission de webmaster',
				'id'		=>	2,
				'author'	=>	'Hugo',
				'content'	=>	'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
				'date'		=>	new \Datetime()),
			array(
				'title'		=>	'Offre de stage webdesigner',
				'id'		=>	3,
				'author'	=>	'Mathieu',
				'content'	=>	'Nous proposons un poste pour webdesigner. Blabla…',
				'date'		=>	new \Datetime())
		);
		return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
			'listAdverts' => $listAdverts
		));
	}

	// La route fait appel à OCPlatformBundle:Advert:view, on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour correspondre au paramètre {id} de la route
	public function viewAction($id)
	{
		$advert = array(
			'title'		=>	'Recherche développpeur Symfony2',
			'id'		=>	$id,
			'author'	=>	'Alexandre',
			'content'	=>	'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'		=>	new \Datetime()
		);

		return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
			'advert' => $advert
		));
	}

	// On récupère tous les paramètres en arguments de la méthode
	public function viewSlugAction($slug, $year, $_format)
	{
		return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format.".");
	}

	public function addAction(Request $request)
	{
		// On récupère le service
		$antispam = $this->container->get('oc_platform.antispam');
		// La gestion d'un formulaire est particulière, mais l'idée est la suivante :
		// Si la requête est en POST, c'est que le visiteur a soumis le formulaire
		if ($request->isMethod('POST')) {
			$text = '...';
			if ($antispam->isSpam($text)) {
				throw new \Exception('Votre message a été détecté comme spam !');
			}			
			// Ici, on s'occupera de la création et de la gestion du formulaire
			$request->addFlash('notice', 'Annonce bien enregistrée.');
			// Puis on redirige vers la page de visualisation de cettte annonce
			return $this->redirectToRoute('oc_platform_view', array('id' => 5));
		}
		// Si on n'est pas en POST, alors on affiche le formulaire
		return $this->render('OCPlatformBundle:Advert:add.html.twig');
	}

	public function editAction($id, Request $request)
	{
		// Ici, on récupérera l'annonce correspondante à $id
		// Même mécanisme que pour l'ajout
		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
			return $this->redirectToRoute('oc_platform_view', array('id' => 5));
		}
		$advert = array(
			'title'		=>	'Recherche développpeur Symfony',
			'id'		=>	$id,
			'author'	=>	'Alexandre',
			'content'	=>	'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
			'date'		=>	new \Datetime()
		);

		return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
			'advert' => $advert
		));
	}

	public function deleteAction($id)
	{
		// Ici, on récupérera l'annonce correspondant à $id
		// Ici, on gérera la suppression de l'annonce en question
		return $this->render('OCPlatformBundle:Advert:delete.html.twig');
	}

	public function menuAction($limit)
	{
		// On fixe en dur une liste ici, bien entendu par la suite
		// on la récupérera depuis la BDD !
		$listAdverts = array(
			array('id' => 2, 'title' => 'Recherche développeur Symfony'),
			array('id' => 5, 'title' => 'Mission de webmaster'),
			array('id' => 9, 'title' => 'Offre de stage webdesigner')
		);

		return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
			// Tout l'intérêt est ici : le contrôleur passe
			// les variables nécessaires au template !
			'listAdverts' => $listAdverts
		));
	}	
}
