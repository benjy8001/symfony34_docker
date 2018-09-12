<?php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{
   /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

	public function load(ObjectManager $manager)
	{
		$userManager = $this->container->get('fos_user.user_manager');
		// Les noms d'utilisateurs à créer
		$listNames = array('Alexandre', 'Marine', 'Anna');

		foreach ($listNames as $name) {
			// On crée l'utilisateur
			$user = $userManager->createUser();
			// Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
			$user->setUsername($name);
			$user->setPassword($name);
			$user->setEmail($name."@ipsum.com");
			$user->setEnabled(true);

			// On ne se sert pas du sel pour l'instant
			//$user->setSalt('');
			// On définit uniquement le role ROLE_USER qui est le role de base
			$user->setRoles(array('ROLE_USER'));

			// On le persiste
			$userManager->updateUser($user, true);
		}
	}
}