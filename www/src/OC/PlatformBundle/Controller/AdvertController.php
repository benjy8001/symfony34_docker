<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;

use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;

class AdvertController extends Controller
{
	const NB_PER_PAGE = 3;

	public function indexAction($page)
	{
		// On ne sait pas combien de pages il y a
		// Mais on sait qu'une page doit être supérieure ou égale à 1
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw $this->createNotFoundException('Page "'.$page.'" inexistante.');
		}

    // On récupère es 'entités
    $listAdverts = $this->getDoctrine()
    	->getManager()
    	->getRepository('OCPlatformBundle:Advert')
			->getAdverts($page, self::NB_PER_PAGE);

    $nbPages = ceil(count($listAdverts) / self::NB_PER_PAGE);

		if ($page > $nbPages) {
			throw $this->createNotFoundException('Page "'.$page.'" inexistante.');
		}

		return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
			'listAdverts' 	=> $listAdverts,
			'nbPages'				=> $nbPages,
			'page'					=> $page
		));
	}

	// La route fait appel à OCPlatformBundle:Advert:view, on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour correspondre au paramètre {id} de la route
	public function viewAction($id)
	{
    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // On récupère l'entité correspondante à l'id $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

		// On récupère la liste des candidatures de cette annonce
		$listApplications = $em
			->getRepository('OCPlatformBundle:Application')
			->findBy(array('advert' => $advert))
		;

    // On récupère maintenant la liste des AdvertSkill
    $listAdvertSkills = $em
			->getRepository('OCPlatformBundle:AdvertSkill')
			->findBy(array('advert' => $advert))
    ;

    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills
    ));
	}

	// On récupère tous les paramètres en arguments de la méthode
	public function viewSlugAction($slug, $year, $_format)
	{
		return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$_format.".");
	}

	public function addAction(Request $request)
	{
    $advert = new Advert();

    // On crée le FormBuilder grâce au service form factory
    $form   = $this->createForm(AdvertType::class, $advert);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($advert);
			$em->flush();

			$this->addFlash('notice', 'Annonce bien enregistrée.');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
	}

	public function editAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
    // On récupère l'entité correspondante à l'id $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(AdvertEditType::class, $advert);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->flush();

			$this->addFlash('notice', 'Annonce bien modifiée.');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
		}

		return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert,
      'form' => $form->createView(),
		));
	}

	public function deleteAction(Request $request, $id)
	{
    $em = $this->getDoctrine()->getManager();
    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
    if (null === $advert) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

		$form = $this->createFormBuilder()->getForm();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->remove($advert);
			$em->flush();

      $this->addFlash('notice', "L'annonce a bien été supprimée.");

      return $this->redirectToRoute('oc_platform_home');			
		}

		return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
			'advert' => $advert,
			'form'   => $form->createView(),
		));
	}

	public function menuAction($limit)
	{
    $em = $this->getDoctrine()->getManager();
    // On récupère l'annonce $id
    $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
    	array(),
    	array('date' => 'desc'),
    	$limit,
    	0
    );

		return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
			// Tout l'intérêt est ici : le contrôleur passe
			// les variables nécessaires au template !
			'listAdverts' => $listAdverts
		));
	}	

  public function purgeAction($days, Request $request)
  {
    $purger = $this->get('oc_platform.purger.advert');
    $purger->purge($days);

    $this->addFlash('notice', 'Les annonces plus vieilles que '.$days.' jours ont été purgées.');

    return $this->redirectToRoute('oc_platform_home');
  } 	
}
