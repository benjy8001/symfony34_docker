<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;

class AdvertController extends Controller
{
	public function indexAction($page)
	{
		// On ne sait pas combien de pages il y a
		// Mais on sait qu'une page doit être supérieure ou égale à 1
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw $this->createNotFoundException('Page "'.$page.'" inexistante.');
		}

		$nbPerPage = 3;

    // On récupère es 'entités
    $listAdverts = $this->getDoctrine()
    	->getManager()
    	->getRepository('OCPlatformBundle:Advert')
    	->getAdverts($page, $nbPerPage);

    $nbPages = ceil(count($listAdverts) / $nbPerPage);

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
    // Création de l'entité Advert
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony.');
    $advert->setAuthor('Alexandre');
		$advert->setEmail('tutu@test.fr');
	  $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

    // Création de l'entité Image
    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    // On lie l'image à l'annonce
    $advert->setImage($image);

		// Création d'une première candidature
		$application1 = new Application();
		$application1->setAuthor('Marine');
		$application1->setEmail('tutu@test.fr');
		$application1->setContent("J'ai toutes les qualités requises.");

		// Création d'une deuxième candidature par exemple
		$application2 = new Application();
		$application2->setAuthor('Pierre');
		$application2->setEmail('toto@test.fr');
		$application2->setContent("Je suis très motivé.");

		// On lie les candidatures à l'annonce
		$application1->setAdvert($advert);
		$application2->setAdvert($advert);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité + l'image (cf attribut cascade)
    $em->persist($advert);
    $em->persist($application1);
    $em->persist($application2);

		// La méthode findAll retourne toutes les catégories de la base de données
		$listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();

		// On boucle sur les catégories pour les lier à l'annonce
		foreach ($listCategories as $category) {
			$advert->addCategory($category);
		}

    // On récupère toutes les compétences possibles
    $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();

    // Pour chaque compétence
    foreach ($listSkills as $skill) {
			// On crée une nouvelle « relation entre 1 annonce et 1 compétence »
			$advertSkill = new AdvertSkill();

			// On la lie à l'annonce, qui est ici toujours la même
			$advertSkill->setAdvert($advert);
			// On la lie à la compétence, qui change ici dans la boucle foreach
			$advertSkill->setSkill($skill);

			// Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
			$advertSkill->setLevel('Expert');

			// Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
			$em->persist($advertSkill);
    }

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();

		// On récupère le service
		$antispam = $this->container->get('oc_platform.antispam');
		// La gestion d'un formulaire est particulière, mais l'idée est la suivante :
		// Si la requête est en POST, c'est que le visiteur a soumis le formulaire
		if ($request->isMethod('POST')) {
			$text = '...';
			if ($antispam->isSpam($text)) {
				throw new \Exception('Votre message a été détecté comme spam !');
			}

	    // On récupère l'EntityManager
	    $em = $this->getDoctrine()->getManager();

	    // Étape 1 : On « persiste » l'entité
	    $em->persist($advert);

	    // Étape 2 : On « flush » tout ce qui a été persisté avant
	    $em->flush();

			// Ici, on s'occupera de la création et de la gestion du formulaire
			$request->addFlash('notice', 'Annonce bien enregistrée.');
			// Puis on redirige vers la page de visualisation de cettte annonce
			return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
		}
		// Si on n'est pas en POST, alors on affiche le formulaire
		return $this->render('OCPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
	}

	public function editAction($id, Request $request)
	{
    // On récupère l'entité correspondante à l'id $id
    $advert = $this->getDoctrine()
    	->getManager()
    	->getRepository('OCPlatformBundle:Advert')
    	->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

		if ($request->isMethod('POST')) {
			$request->addFlash('notice', 'Annonce bien modifiée.');
			return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
		}

		return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
			'advert' => $advert
		));
	}

	public function deleteAction($id)
	{
    $em = $this->getDoctrine()->getManager();
    // On récupère l'annonce $id
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
    if (null === $advert) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
			$advert->removeCategory($category);
    }
    // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
    // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
    // On déclenche la modification
    $em->flush();

		return $this->render('OCPlatformBundle:Advert:delete.html.twig');
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

    $request->addFlash('notice', 'Les annonces plus vieilles que '.$days.' jours ont été purgées.');

    return $this->redirectToRoute('oc_platform_home');
  } 	
}
