<?php

namespace OC\PlatformBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use OC\PlatformBundle\Validator\Antiflood;

/**
 * Advert
 *
 * @ORM\Table(name="oc_advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="title", message="Une annonce existe déjà avec ce titre.")
 */
class Advert
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
	 * @Assert\Valid()
	 */
	private $image;

	/**
	 * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
	 * @ORM\JoinTable(name="oc_advert_category")
	 */
	private $categories;

	/**
	 * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User")
	 * @ORM\JoinTable(name="oc_user")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert")
	 */
	private $applications;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime", nullable=false)
	 * @Assert\DateTime()
	 */
	private $date;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255, unique=true)
	 * @Assert\Length(min=10, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="author", type="string", length=255)
	 * @Assert\Length(min=2)
	 */
	private $author;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=true)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text")
	 * @Assert\NotBlank()
	 * @Antiflood()
	 */
	private $content;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="nb_applications", type="integer", options={"default" : 0})
	 */
	private $nbApplications = 0;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="published", type="boolean")
	 */
	private $published = false;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
	 */
	private $updatedAt;


	public function __construct()
	{
		$this->date = new \DateTime();
		$this->categories = new ArrayCollection();
		$this->applications = new ArrayCollection();
	}

	/**
	 * Doctrine callback to update the updated_at date
	 * @ORM\PreUpdate
	 */
	public function updateDate()
	{
		$this->setUpdatedAt(new \Datetime());
	}

	public function increaseApplication()
	{
		$this->nbApplications++;
	}

	public function decreaseApplication()
	{
		$this->nbApplications--;
	}

	/**
	 * Get id.
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set date.
	 *
	 * @param \DateTime $date
	 *
	 * @return Advert
	 */
	public function setDate($date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date.
	 *
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set title.
	 *
	 * @param string $title
	 *
	 * @return Advert
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title.
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set author.
	 *
	 * @param string $author
	 *
	 * @return Advert
	 */
	public function setAuthor($author)
	{
		$this->author = $author;

		return $this;
	}

	/**
	 * Get author.
	 *
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * Set content.
	 *
	 * @param string $content
	 *
	 * @return Advert
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content.
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set published.
	 *
	 * @param bool $published
	 *
	 * @return Advert
	 */
	public function setPublished($published)
	{
		$this->published = $published;

		return $this;
	}

	/**
	 * Get published.
	 *
	 * @return bool
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * Set image.
	 *
	 * @param \OC\PlatformBundle\Entity\Image $image
	 *
	 * @return Advert
	 */
	public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image.
	 *
	 * @return \OC\PlatformBundle\Entity\Image
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Add category.
	 *
	 * @param \OC\PlatformBundle\Entity\Category $category
	 *
	 * @return Advert
	 */
	public function addCategory(\OC\PlatformBundle\Entity\Category $category)
	{
		$this->categories[] = $category;

		return $this;
	}

	/**
	 * Remove category.
	 *
	 * @param \OC\PlatformBundle\Entity\Category $category
	 *
	 * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
	 */
	public function removeCategory(\OC\PlatformBundle\Entity\Category $category)
	{
		return $this->categories->removeElement($category);
	}

	/**
	 * Get categories.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
	 * Add application.
	 *
	 * @param \OC\PlatformBundle\Entity\Application $application
	 *
	 * @return Advert
	 */
	public function addApplication(\OC\PlatformBundle\Entity\Application $application)
	{
		$this->applications[] = $application;

		// On lie l'annonce à la candidature
		$application->setAdvert($this);        

		return $this;
	}

	/**
	 * Remove application.
	 *
	 * @param \OC\PlatformBundle\Entity\Application $application
	 *
	 * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
	 */
	public function removeApplication(\OC\PlatformBundle\Entity\Application $application)
	{
		return $this->applications->removeElement($application);
	}

	/**
	 * Get applications.
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getApplications()
	{
		return $this->applications;
	}

	/**
	 * Set email.
	 *
	 * @param string $email
	 *
	 * @return Advert
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email.
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set nbApplications.
	 *
	 * @param int $nbApplications
	 *
	 * @return Advert
	 */
	public function setNbApplications($nbApplications)
	{
		$this->nbApplications = $nbApplications;

		return $this;
	}

	/**
	 * Get nbApplications.
	 *
	 * @return int
	 */
	public function getNbApplications()
	{
		return $this->nbApplications;
	}

	/**
	 * Set updatedAt.
	 *
	 * @param \DateTime|null $updatedAt
	 *
	 * @return Advert
	 */
	public function setUpdatedAt(\Datetime $updatedAt = null)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Get updatedAt.
	 *
	 * @return \DateTime|null
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * Set slug.
	 *
	 * @param string $slug
	 *
	 * @return Advert
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug.
	 *
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @Assert\Callback
	 */
	public function isContentValid(ExecutionContextInterface $context)
	{
		$forbiddenWords = array('démotivation', 'abandon');

		// On vérifie que le contenu ne contient pas l'un des mots
		if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getContent())) {
			// La règle est violée, on définit l'erreur
			$context
				->buildViolation('Contenu invalide car il contient un mot interdit.')	// message
				->atPath('content')														// attribut de l'objet qui est violé
				->addViolation()	// ceci déclenche l'erreur, ne l'oubliez pas
			;
		}
	}

    /**
     * Set user.
     *
     * @param \OC\UserBundle\Entity\User|null $user
     *
     * @return Advert
     */
    public function setUser(\OC\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \OC\UserBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
